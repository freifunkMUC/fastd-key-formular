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
    $message = '';

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
                "# Knotenname: ".$_POST['nodename']."\n" . "# Ansprechpartner: " . $_POST['contactname'] . "\n" . "# Kontakt: " . $_POST['contactmail']
                . "\n" . "# Koordinaten: " . $_POST['coordinates_lat'] . " " . $_POST['coordinates_long'] . "\n" . "# MAC: " . $_POST['macaddress'] . "\n" . "# Token: " . uniqid()
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
    $message = 'Bitte Nodename, MAC-Adresse und Key angeben';
}

?>

<html lang="en">
<head>
    <meta charset="utf-8">

    <title>Freifunk München - Knoten hinzufügen</title>
</head>

<style type="text/css">
.tg  {font-family:Arial, sans-serif;border-collapse:collapse;border-spacing:0;}
.tg td{font-size:14px;overflow:hidden;word-break:normal;}
.tg td.mandatory{font-weight:bold;}
</style>

<body>

<div style="float: left; padding-left: 50px">
    <img style="display: block; float:left; width:100px" src="images/ffm-logo.png"/>
    <h1>Freifunk München</h1>

    <p class="message">
        <?= $message; ?>
    </p>

    <form action="index.php" method="post">
    <table class="tg">
      <tr>
        <td class="tg-031e mandatory">Knotenname</td>
      </tr>
      <tr>
        <td class="tg-031e"><input type="text" width="60" name="nodename"/> (z.B. MeineStrasse_14)</td>
      </tr>
      <tr>
        <td class="tg-031e mandatory">MAC-Adresse</td>
      </tr>
      <tr>
        <td class="tg-031e"><input type="text" width="60" name="macaddress"/> (z.B. ff:00:bb:11:22:33)</td>
      </tr>
      <tr>
        <td class="tg-031e mandatory">Key</td>
      </tr>
      <tr>
        <td class="tg-031e"><input type="text" width="60" name="key"/> (64 stellig)</td>
      </tr>
      <tr>
        <td class="tg-031e">Ansprechpartner</td>
      </tr>
      <tr>
        <td class="tg-031e"><input type="text" width="60" name="contactname"/> (z.B. John)</td>
      </tr>
      <tr>
        <td class="tg-031e">Kontaktmail</td>
      </tr>
      <tr>
        <td class="tg-031e"><input type="text" width="80" name="contactmail"/> (z.B. john@example.com)</td>
      </tr>
      <tr>
        <td class="tg-031e">Koordinaten</td>
      </tr>
      <tr>
        <td class="tg-031e">
            <input type="text" size="8" maxlength="8" name="coordinates_lat"/>
            <input type="text" size="8" maxlength="8" name="coordinates_long"/>
             (z.B. 48.18211 11.57789)
        </td>
      </tr>
      <tr>
        <td class="tg-031e mandatory">
            <input type="submit" value="eintragen" ?>
            (benötigte Felder)
        </td>
      </tr>
    </table>
    </form>

</div>
</body>
</html>


