## API Get QR

# contoh php

```php
<?php

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://api.fonnte.com/qr',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => array(
    'type' => 'qr',
    'whatsapp' => '628123456789'
  ),
  CURLOPT_HTTPHEADER => array(
    'Authorization: TOKEN'
  ),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;
```

# contoh response

-belum connect

```json
{
    "status": true,
    "url": "iVBORw0KGgoAAAANSUhEUgAAARQAAAEUCAYAA..."
}
```

-sudah connect

```json
{
    "reason": "device already connect",
    "status": false
}
```

-error

```json
{
    "reason": "token invalid",
    "status": false
}
```

# cara tampilkan qr code

dengan url tadi

```php

<img src="data:image/png;base64,<?= $qr?>">
```

## disconnect device

```php

<?php

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://api.fonnte.com/disconnect',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_HTTPHEADER => array(
    'Authorization: TOKEN'
  ),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;

```

# contoh response

-berhasil disconnect

```json
{
    "detail": "device disconnected",
    "status": true
}
```

-error

```json
{
    "detail": "token invalid",
    "status": false
}
```

-already disconnect

```json
{
    "detail": "device already disconnected",
    "status": false
}
```

## Basic cara kirim pesan

```php
<?php

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://api.fonnte.com/send',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => array(
'target' => '08123456789|Fonnte|Admin,08123456789|Lili|User',
'message' => 'test message to {name} as {var1}',
'url' => 'https://md.fonnte.com/images/wa-logo.png',
'filename' => 'filename',
'schedule' => 0,
'typing' => false,
'delay' => '2',
'countryCode' => '62',
'file' => new CURLFile("localfile.jpg"),
'location' => '-7.983908, 112.621391',
'followup' => 0,
),
  CURLOPT_HTTPHEADER => array(
    'Authorization: TOKEN'
  ),
));

$response = curl_exec($curl);
if (curl_errno($curl)) {
  $error_msg = curl_error($curl);
}
curl_close($curl);

if (isset($error_msg)) {
 echo $error_msg;
}
echo $response;
```

# contoh response

-berhasil kirim pesan

```json
{
    "detail": "success! message in queue",
    "id": [
        "80367170"
    ],
    "process": "pending",
    "requestid": 2937124,
    "status": true,
    "target": [
        "6282227097005"
    ]
}
```

-error

```json
{
    "Status": false,
    "reason": "token invalid",
    "requestid": 2937124
}
```

-error

```json
{
    "Status": false,
    "reason": "devices must belong to an account",
    "requestid": 2937124
}
```

## Get device

```php
<?php

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://api.fonnte.com/device',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_HTTPHEADER => array(
    'Authorization: TOKEN'
  ),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;
```

# contoh response

```json
{
    "device": "6282227097005",
    "device_status": "connect",
    "expired": "18 November 2029",
    "messages": 16785,
    "name": "Fonnte admin",
    "package": "Reguler",
    "quota": "78",
    "status": true
}
```

# contoh response

```json
{
    "reason": "token invalid",
    "status": false
}
```