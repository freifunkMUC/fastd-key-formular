<?php
/*
# Knotenname: Abtstr_14
# Ansprechpartner: Ole
# Kontakt: mail@dreessen.de
# Koordinaten: 48.18211 11.57789
# MAC: e8:94:f6:4b:7f:1c
# Token: 78asdhfase
key "60acc9922fff4c12dc1eee1f2eeddb77b90c5a48388858ab79b44c9e4964296f";

Wäre sehr cool, wenn Du das noch reinbasteln könntest. Das anschließend
generierte File hat dann folgenden Dateinamen:

Abtstr_14@e8:94:f6:4b:7f:1c@a277185b5d8f5088a2e26efa90ab75c903d428c2481de038ee0c33de6093e0a5@78asdhfase

Also <knotenname>@<mac-Adresse>@fastd-key

*/

if (isset( $_POST['key'] ) && isset( $_POST['nodename'] )
    && isset( $_POST['macaddress'] )
) {

    if (!preg_match('/[a-f0-9]{64}/', $_POST['key'])) {
        $message .= 'Erwarte Hex-Key mit Länge 64<br />';
    } elseif (!preg_match('/[A-Za-z_0-9]*/', $_POST['nodename'])) {
        $message .= 'Kontenname darf nur Buchstaben, Zahlen und Unterstrich enthalten<br />';
    } elseif (!preg_match('/[a-z:0-9]{17}/', $_POST['macaddress'])) {
        $message .= 'MAC-Adresse bitte in der Form f1:8e:11:22:33:a4 angeben<br />';
    } else {
        $fileName = $_POST['nodename'] . '@' . $_POST['macaddress'] . '@' . $_POST['key'];
        $filePath = __DIR__ . '/keys/' . $fileName;

        if (!file_exists($filePath)) {

            $fileContent =
                "# Knotenname: Abtstr_14\n" . "# Ansprechpartner: " . $_POST['contactname'] . "\n" . "# Kontakt: " . $_POST['contactmail']
                . "\n" . "# Koordinaten: " . $_POST['coordinates'] . "\n" . "# MAC: " . $_POST['macaddress'] . "\n" . "# Token: " . uniqid()
                . "\n" . "key \"" . $_POST['key'] . "\";\n";

            file_put_contents($filePath, $fileContent);
            $message = "Key " . $fileName . " eingetragen";
            $message .= "<pre>";
            $message .= $fileContent;
            $message .= "</pre>";
            $message .= "<pre>";
            $message .= shell_exec('./push.sh');
            $message .= "</pre>";
        } else {
            $message = "Es existiert bereits ein Key für diesen Host";
        }
    }
} else {
    $message = 'Bitte Nodename + Key angeben';
}

?>

<html lang="en">
<head>
    <meta charset="utf-8">

    <title>Freifunk München - Knoten hinzufügen</title>
</head>

<body>

<img style="display: block; float:left" src="images/ffm-logo.png"/>

<div style="float: left; padding-left: 50px">
    <h1>Freifunk München</h1>

    <p class="message">
        <?= $message; ?>
    </p>

    <form action="index.php" method="post">
        Knotenname (Blastr_14): <input type="text" width="60" name="nodename"/><br/>
        Ansprechpartner (John): <input type="text" width="60" name="contactname"/><br/>
        Kontaktmail (john@example.com): <input type="text" width="60" name="contactmail"/><br/>
        Koordinaten (48.18211 11.57789): <input type="text" width="60" name="coordinates"/><br/>
        MAC: (ff:00:bb:11:22:33): <input type="text" width="60" name="macaddress"/><br/>
        Key: (64 stellig): <input type="text" width="60" name="key"/><br/>
        <input type="submit" value="eintragen" ?>
    </form>
</div>
</body>
</html>


