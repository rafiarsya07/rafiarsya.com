# Replaces the contents of github.com/rafiarsya07/rafiarsya.com with the
# current v7 portfolio and removes the old flat HTML/CSS/JS site.
# Run it from PowerShell. It stops at the first error.

$ErrorActionPreference = "Stop"
Set-Location "E:\Unfinished Portfolio"

# 1. the five blog posts that were unlisted are dropped from the repo too
$old = @(
  "v7/content/blog/csastudy.php",
  "v7/content/blog/nase.php",
  "v7/content/blog/papermind.php",
  "v7/content/blog/rafifinance.php",
  "v7/content/blog/sqlsteam.php"
)
foreach ($f in $old) { if (Test-Path $f) { git rm -f --ignore-unmatch $f } }

# 2. commit everything that changed in the working tree
git add -A
git commit -m "portfolio: uniform figure widths, project card links, Nalar rename, blog cut to two expanded posts"

# 3. look before you leap: what does main gain and lose
Write-Host "`n--- branches ---" -ForegroundColor Cyan
git branch -vv
Write-Host "`n--- what main would gain from this branch ---" -ForegroundColor Cyan
git log --oneline origin/main..HEAD
Write-Host "`n--- what main has that this branch does not (should be empty) ---" -ForegroundColor Cyan
git log --oneline HEAD..origin/main

Write-Host "`nIf the last list above is empty, this is a fast-forward and the next line is safe." -ForegroundColor Yellow
Read-Host "Press Enter to push, or Ctrl+C to stop"

# 4. push this branch onto main. --force-with-lease refuses if someone else
#    pushed to main since the last fetch, so it cannot silently discard work.
git push --force-with-lease origin HEAD:main

Write-Host "`nPushed. Cloudflare Pages will pick it up if the repo is connected." -ForegroundColor Green
Write-Host "To deploy the built site by hand instead: npx wrangler pages deploy dist" -ForegroundColor Green
