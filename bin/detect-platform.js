const { execSync } = require("child_process");

const isWindows = process.platform === "win32";
const command = isWindows ? "bun run export-changes-win" : "bun run export-changes-mac";

console.log(`Running: ${command}`);
execSync(command, { stdio: "inherit", shell: true });


/*
* git diff --name-status origin/main...origin/dev | ForEach-Object { ($_ -split "\s+", 3) -join "," } | Out-File changes.csv -Encoding utf8


"Status,Alter Dateiname,Neuer Dateiname" | Out-File changes.csv -Encoding utf8  # Kopfzeile hinzufügen
git diff --diff-filter=R --name-status origin/main...origin/dev | ForEach-Object { ($_ -split "\s+", 3) -join "," } | Out-File changes.csv -Encoding utf8 -Append



"Status,Alter Dateiname,Neuer Dateiname" | Out-File changes.csv -Encoding utf8; git diff --diff-filter=R --name-status origin/main...origin/dev | ForEach-Object { ($_ -split "\s+", 3) -join "," } | Out-File changes.csv -Encoding utf8 -Append


*
* */
