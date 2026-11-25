#!/usr/bin/env bash
# Decides whether a pushed tag may be deployed. A release tag must:
#   1. look like vMAJOR.MINOR.PATCH (e.g. v1.2.3)
#   2. equal "v" + the "version" in package.json at the tagged commit (= the version was bumped)
#   3. be higher than every other release tag (no accidental rollbacks or duplicates)
#   4. point at a commit that is already on master (tested, reviewed code only)
# Also writes release notes (commits since the previous release) to the job summary.
#
# Env: RELEASE_TAG (e.g. v1.2.3), MAIN_BRANCH_REF (default origin/master), GITHUB_STEP_SUMMARY, GITHUB_OUTPUT (optional)
set -euo pipefail

tag="${RELEASE_TAG:?RELEASE_TAG is required, e.g. v1.2.3}"
main_ref="${MAIN_BRANCH_REF:-origin/master}"
summary="${GITHUB_STEP_SUMMARY:-/dev/null}"

fail() {
	echo "::error title=Release $tag rejected::$1"
	echo "### ❌ Release \`$tag\` rejected: $1" >> "$summary"
	exit 1
}

# 1. Format
[[ "$tag" =~ ^v[0-9]+\.[0-9]+\.[0-9]+$ ]] || fail "tag must look like vX.Y.Z (for example v1.2.3)"
version="${tag#v}"

# 2. Matches package.json at the tagged commit
package_version="$(git show "$tag:package.json" | node -e 'let s="";process.stdin.on("data",d=>s+=d).on("end",()=>console.log(JSON.parse(s).version))')"
[[ "$package_version" == "$version" ]] \
	|| fail "package.json at this tag says \"$package_version\"; bump it to \"$version\" (npm version …) and tag that commit"

# 3. Higher than every other release tag
previous="$(git tag --list 'v*' | grep -E '^v[0-9]+\.[0-9]+\.[0-9]+$' | grep -vxF "$tag" | sort -V | tail -n 1 || true)"
if [[ -n "$previous" ]]; then
	highest="$(printf '%s\n%s\n' "$previous" "$tag" | sort -V | tail -n 1)"
	[[ "$highest" == "$tag" ]] || fail "version must be higher than $previous (the latest release)"
fi

# 4. Already on master
git merge-base --is-ancestor "$tag^{commit}" "$main_ref" \
	|| fail "the tagged commit is not on master; merge it into master first, then tag"

# Release notes
{
	echo "## 🏷️ Release \`$tag\`"
	if [[ -n "$previous" ]]; then
		echo "Changes since \`$previous\`:"
		echo
		git log --no-merges --pretty='- %s (`%h`, %an)' "$previous..$tag"
	else
		echo "First release."
	fi
	echo
} >> "$summary"

[[ -n "${GITHUB_OUTPUT:-}" ]] && echo "previous=$previous" >> "$GITHUB_OUTPUT"
if [[ -n "$previous" ]]; then
	echo "Release $tag approved (previous release: $previous)"
else
	echo "Release $tag approved (first release)"
fi
