#!/usr/bin/env bash
# Tests for scripts/ci/check-release.sh, using a throwaway git repository.
# Run: tests/ci/check-release.test.sh
set -euo pipefail

script="$(cd "$(dirname "$0")/../.." && pwd)/scripts/ci/check-release.sh"
repo="$(mktemp -d)"
trap 'rm -rf "$repo"' EXIT
failures=0

git_quiet() { git -C "$repo" -c user.name=t -c user.email=t@t "$@" > /dev/null 2>&1; }
commit_version() { # commit_version <version> — commit package.json with that version on the current branch
	printf '{ "name": "x", "version": "%s" }\n' "$1" > "$repo/package.json"
	git_quiet add package.json
	git_quiet commit -m "version $1"
}
expect() { # expect <pass|fail> <description> <tag> [expected output fragment]
	local want="$1" name="$2" tag="$3" fragment="${4:-}" output status
	output="$(cd "$repo" && RELEASE_TAG="$tag" MAIN_BRANCH_REF=master GITHUB_STEP_SUMMARY=/dev/null "$script" 2>&1)" && status=pass || status=fail
	if [[ "$status" == "$want" && ( -z "$fragment" || "$output" == *"$fragment"* ) ]]; then
		echo "  ✅ $name"
	else
		echo "  ❌ $name (wanted $want${fragment:+ containing \"$fragment\"}, got $status)"; echo "$output" | sed 's/^/       /'
		failures=$((failures + 1))
	fi
}

echo "check-release.sh"
git_quiet init -b master
commit_version 1.0.0
git_quiet tag v1.0.0
expect pass "first-ever release is allowed"                   v1.0.0  "(first release)"
expect pass "redeploying the latest release is allowed"       v1.0.0  "(first release)"

commit_version 1.0.1
git_quiet tag v1.0.1
git_quiet tag v1.0.2-not-bumped        # tag on a commit whose package.json still says 1.0.1
git_quiet tag v1.0.1-copy              # not vX.Y.Z, so never treated as a release
expect fail "older release cannot be redeployed (no accidental rollback)" v1.0.0 "must be higher than v1.0.1"
expect pass "bumped tag matching package.json is released"     v1.0.1  "(previous release: v1.0.0)"
expect fail "tag must match package.json version"              v1.0.2-not-bumped "vX.Y.Z"
expect fail "non-semver tag is rejected"                       v1.0    "vX.Y.Z"

git_quiet tag v1.0.3                   # package.json is 1.0.1 here
expect fail "tag version differs from package.json"            v1.0.3  "package.json"

commit_version 1.0.5
git_quiet tag v1.0.5
commit_version 1.0.4                   # going backwards
git_quiet tag v1.0.4
expect fail "version lower than the latest release is rejected" v1.0.4 "must be higher than v1.0.5"

git_quiet checkout -b feature
commit_version 1.0.6
git_quiet tag v1.0.6
expect fail "tagged commit must already be on master"          v1.0.6  "not on master"
git_quiet checkout master
git_quiet merge --ff-only feature
expect pass "same tag passes once merged into master"          v1.0.6  "(previous release: v1.0.5)"

if (( failures > 0 )); then echo "$failures test(s) failed"; exit 1; fi
echo "All check-release tests passed"
