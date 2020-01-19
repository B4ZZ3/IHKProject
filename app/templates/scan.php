<?php include "templates/include/header.php" ?>
<div class="container d-flex flex-column align-content-around align-items-center justify-content-center flex-wrap" style="height:100%;">
    <div id="errorMessage" class="errorMessage"><?php echo $results['errorMessage'] ?></div>
<?php
    if($results["value"] === "office") {
?>
    <h3><?php echo htmlspecialchars( $results["scanHeadline"] )?></h3>
    <form action="index.php?action=postQRCode" method="post">
        <div class="d-flex">
        <input type="text" name="qrValue" size="20" style="width:70%;" placeholder="Ergebnis des QR-Codes" class="form-control">
        <label for="qrInput" style="margin:0;margin-left:5px;" class="btn btn-outline-secondary">Scan&nbsp;<i class="fas fa-qrcode"></i><input id="qrInput" class="inputfile" type="file" accept="image/*" capture="environment" onchange="openQRCamera(this, 'office');" tabindex=-1></label> 
        </div>
        <div class="justify-content-center" id="submitQRCode">
            <button type="submit" class="btn btn-success" name="qrCodeBuero" value="QRCode">QR-Code bestätigen&nbsp;<i class="fas fa-angle-right"></i></button>
        </div>
    </form>   
    <div class="btn-divider"></div>
    <a href="index.php?action=endInventur" class="btn btn-outline-primary"><i class="fas fa-angle-left"></i> <?php echo htmlspecialchars( $results["secondaryBtnText"] )?></a>
<?php 
    }
    elseif($results["value"] === "item") {
?>
    <h3><?php echo htmlspecialchars( $results["scanHeadline"] )?></h3>
    <form action="index.php?action=postQRCode" method="post">
        <div class="d-flex">
        <input type="text" name="qrValue" size="20" style="width:70%;" placeholder="Ergebnis des QR-Codes" class="form-control">
        <label for="qrInput" style="margin:0;margin-left:5px;" class="btn btn-outline-secondary">Scan&nbsp;<i class="fas fa-qrcode"></i><input id="qrInput" class="inputfile" type="file" accept="image/*" capture="environment" onchange="openQRCamera(this, 'item');" tabindex=-1></label> 
        </div>
        <div class="justify-content-center" id="submitQRCode">
            <button type="submit" class="btn btn-success" name="qrCodeItem" value="QRCode">QR-Code bestätigen&nbsp;<i class="fas fa-angle-right"></i></button>
        </div>
    </form>
    <div class="btn-divider"></div>
    <a href="index.php?action=scanBuero" class="btn btn-outline-primary"><i class="fas fa-angle-left"></i> <?php echo htmlspecialchars( $results["secondaryBtnText"] )?></a>
<?php 
    }
?>
</div>
<script>
    function openQRCamera(node, type) {
        var reader = new FileReader();
        reader.onload = function() {
            node.value = "";
            qrcode.callback = function(res) {
                if(res instanceof Error) {
                    alert("Kein QR-Code gefunden. Bitte stellen Sie sicher, dass der QR-Code im Rahmen der Kamera liegt und versuchen Sie es erneut.");
                }
                else {
                    node.parentNode.previousElementSibling.value = res;
                    if(controllQRCode(res, type)) {
                        document.getElementById('submitQRCode').style.display = 'flex';
                    }
                }
            };
            qrcode.decode(reader.result);
        };
        reader.readAsDataURL(node.files[0]);
    }

    function controllQRCode(result, type) {
        if(type === "office") {
            if(String(result.split("=", 1)) !== "BueroId"){
                document.getElementById('errorMessage').style.display = 'inline-flex';
                return false;
            }
            else {
                document.getElementById('errorMessage').style.display = 'none';
                return true;
            }
        }
        else if(type === "item") {
            if(String(result.split("=", 1)) !== "Inventarnummer"){
                document.getElementById('errorMessage').style.display = 'inline-flex';
                return false;
            }
            else {
                document.getElementById('errorMessage').style.display = 'none';
                return true;
            }
        }
    }

</script>
<?php include "templates/include/footer.php" ?>