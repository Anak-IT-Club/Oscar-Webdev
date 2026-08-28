$tmp = "C:\Users\LAB-TJKT\AppData\Local\Temp\opencode"
$port = 8135
Start-Process -NoNewWindow -FilePath "C:\php\php.exe" -ArgumentList "artisan serve --port=$port"
Start-Sleep -Seconds 4
$jar = "$tmp\lg.txt"
curl.exe -s -c $jar "http://localhost:$port/login" -o "$tmp\lg.html"
$html = Get-Content "$tmp\lg.html" -Raw
$token = if ($html -match '_token" value="([^"]+)"') { $Matches[1] } else { "" }
$body = "_token=$token&email=admin@gmail.com&password=admin12345&remember=on"
$hdr = curl.exe -s -i -b $jar -c $jar -X POST -d $body "http://localhost:$port/login" -o "$tmp\resp.html" -D "$tmp\hdr.txt"
$head = Get-Content "$tmp\hdr.txt" -Raw
$status = if ($head -match 'HTTP/1.1 (\d+)') { $Matches[1] } else { "?" }
$loc = if ($head -match '(?m)^Location: (.+)') { $Matches[1].Trim() } else { "(none)" }
Write-Output "remember=on => HTTP $status | Location: $loc"
Stop-Process -Name php -Force -ErrorAction SilentlyContinue
Remove-Item "$tmp\lg.txt","$tmp\lg.html","$tmp\resp.html","$tmp\hdr.txt" -Force -ErrorAction SilentlyContinue