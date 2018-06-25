param($operation, $componentName, $url, $destinationPath, $installerFileName, $registryDictionary, $installerCacheFolder = $env:TEMP, $offlineMode)

function DownloadFile($url, $output)
{
    $startTime = Get-Date

    if ($offlineMode)
    {
        Write-Output "Skipping downloading in offline mode"
    }
    elseif (Test-Path $output)
    {
        Write-Output "Skipping downloading since file already exists in cache $output"
    }
    else
    {
        Write-Output "Downloading $url to cache $output"
        $parentDir = Split-Path $output
        if (!(Test-Path $parentDir))
        {
            mkdir $parentDir | out-null
        }

        (New-Object System.Net.WebClient).DownloadFile($url, $output)
        Write-Output "Elapse Time: $((Get-Date).Subtract($startTime).TotalSeconds) second(s)"
    }
}

function Expand-ZIPFile($file, $destination)
{
    if (!(Test-Path $destination))
    {
        New-Item $destination -ItemType directory | out-null
    }

    $appHost = New-Object -ComObject Shell.Application
    $zipSource = $appHost.NameSpace($file)
    $files = $zipSource.Items()
    $zipTarget = $appHost.NameSpace($destination)
    $NoProgre