#!/usr/bin/env bash
# Appends a step result to the GitHub Actions job summary.
# Usage: summary.sh "<title>" "<outcome: success|failure|skipped>" [log-file]
set -euo pipefail

title="$1"
outcome="$2"
log_file="${3:-}"

case "$outcome" in
	success) icon="✅" ;;
	failure) icon="❌" ;;
	*) icon="⏭️" ;;
esac

if [[ -z "${GITHUB_STEP_SUMMARY:-}" ]]; then
	echo "$icon $title: $outcome"
	exit 0
fi

{
	echo "### $icon $title"
	if [[ -n "$log_file" && -s "$log_file" ]]; then
		echo "<details><summary>Output</summary>"
		echo
		echo '```text'
		# Strip colour codes; keep the summary small enough for GitHub (1 MiB limit per step).
		sed 's/\x1b\[[0-9;]*[A-Za-z]//g' "$log_file" | tail -n 200
		echo '```'
		echo "</details>"
	fi
	echo
} >> "$GITHUB_STEP_SUMMARY"
