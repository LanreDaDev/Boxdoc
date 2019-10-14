<?php
include("../inc/loggedin.php");
$pageTitle = "Add";
include("../inc/adminHeader.php");

function customeSize($fileName, $folder, $newWidth)
{
    list($width, $height) = getimagesize($fileName);
    $imgRatio = $width / $height;

    $newHeight = $newWidth / $imgRatio;
   


    $newFile = imagecreatetruecolor($newWidth, $newHeight);
    $source = imagecreatefromjpeg($fileName); //if png doesn work try imagecreatefrompng()
    imagecopyresampled($newFile, $source, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
    $newFileName = $folder . basename($_FILES['boxerPic']['name']);

    imagejpeg($newFile, $newFileName, 80); // if png doesn work, try imagepng()
    imagedestroy($newFile);
    imagedestroy($source);
}

$thumbnail = "../img/thumbnail/";
$display = "../img/display/";
$original = "../img/uploads/";



if (isset($_POST['submit'])) {

    $valid = true;
    $errorMessage = "";
    //Infomation Collection
    $boxerName = ucwords(trim($_POST['boxerName']));
    $bout = $_POST['bout'];
    $koPercent = $_POST['koPercent'];
    $status = ucwords(trim($_POST['status']));
    $titles = $_POST['titles']; //can be null
    $alias = ucwords(trim($_POST['alias'])); //can be null
    $dob = $_POST['dob'];
    $nationality = $_POST['countries'];
    $division = $_POST['division'];
    $stance = $_POST['stance'];
    $height = $_POST['height']; //can be null
    $reach = $_POST['reach']; //can be null
    $youtubeURL = $_POST['youtubeURL']; //can be null
    $star = $_POST['star']; //can be null
    $ranking = $_POST['ranking']; //can be null
    $win = $_POST['win'];
    $lose = $_POST['lose'];
    $draw = $_POST['draw'];
    // Image infomation collection
    $fileName = $_FILES['boxerPic']['name'];
    $tempName = $_FILES['boxerPic']['tmp_name'];
    $size = $_FILES['boxerPic']['size'];
    $fileType = $_FILES['boxerPic']['type'];
    $error = $_FILES['boxerPic']['error'];
    // Date regex

    $dateRegex = "/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/";
    // Validations


    //name vals
    if ($boxerName == "") {
        $errorMessage = "Please enter a boxer's name. <br>";
        $valid = false;
    }
    if (is_numeric($boxerName) == true) {
        $errorMessage .= "Please enter a string in for the Boxers name. <br>";
        $valid = false;
    }


    //bout vals
    if ($bout == "") {
        $errorMessage .= "Please enter the number of bouts. ";
        $valid = false;
    }
    if (is_numeric($bout) == false) {
        $errorMessage .= "Please enter a number for the NUMBER of bouts. <br>";
        $valid = false;
    }

    //KO percent vals
    if ($koPercent == "") {
        $errorMessage .= "Please enter the knockout percentage.";
        $valid = false;
    }
    if (is_numeric($koPercent) == false) {
        $errorMessage .= " Please enter a number for Knockout Percentage. <br>";
        $valid = false;
    }


    if ($dob == "") {
        $errorMessage .= "Please enter the DOB. <br>";
        $valid = false;
    }
    if ($dob != "") {
        if (!preg_match($dateRegex, $dob)) {
            $valid = false;
            $errorMessage .= "Not a Valid Date. Format: YYYY/MM/DD </br>";
        }
    }


    if ($nationality == "") {
        $errorMessage .= "Please enter the nationality. <br>";
        $valid = false;
    }
    if ($division == "") {
        $errorMessage .= "Please enter the division. <br>";
        $valid = false;
    }
    if ($stance == "") {
        $errorMessage .= "Please enter the stance. <br>";
        $valid = false;
    }



    if ($win == "") {
        $errorMessage .= "Please enter the number of wins. ";
        $valid = false;
    }
    if (is_numeric($win) == false) {
        $errorMessage .= " Please enter a number for the NUMBER of wins. <br>";
        $valid = false;
    }
    if ($lose == "") {

        $errorMessage .= "Please enter the number of loses. ";
        $valid = false;
    }
    if (is_numeric($lose) == false) {
        $errorMessage .= " Please enter a number for the NUMBER of wins. <br>";
        $valid = false;
    }
    if ($draw == "") {
        $errorMessage .= "Please enter the number of draws. ";
        $valid = false;
    }
    if (is_numeric($draw) == false) {
        $errorMessage .= " Please enter a number for the NUMBER of wins. <br>";
        $valid = false;
    }

    // Image validations

    if ($fileName == "") {
        $errorMessage .= "Please select an image to upload. <br>";
        $valid = false;
    }
    if ($size > 1000000) {
        $valid = false;
        $errorMessage .= " File size to big. 2Mb limit. <br>";
    }

    if ($fileType  != "image/jfif" && $fileType  != "image/jpeg" && $fileType != "image/pjpeg" && $fileType != "image/png") {
        $valid = false;
        $errorMessage .= " Only jpgs and pngs allowed <br>";
    }
    if ($error > 0) {
        $valid = false;
        $errorMessage .= " An error of type " . $error . " occurred. <br>";
    }

    //

    if ($valid == true) {

        if (move_uploaded_file($tempName, $original . $fileName)) {
            $thisFile = $original . basename($fileName);
            customeSize($thisFile, $thumbnail, 150);
            customeSize($thisFile, $display, 600);

            $successMessage .= " Upload Successful. <br>";
            //insert to db
            $sql = "INSERT INTO boxer (name, bout, koPercent, status, titles, alias, dob, nationality, division, stance, height, reach, image,	youtubeURL,star, ranking, win, lose, draw) VALUES ('$boxerName ','$bout','$koPercent' ,'$status' ,'$titles' ,'$alias' ,'$dob' ,'$nationality' ,'$division' ,'$stance' ,'$height' ,'$reach' ,'$fileName','$youtubeURL','$star','$ranking','$win','$lose','$draw')";


            if (mysqli_query($conn, $sql)) {
                $successMessage .= "Record Inserted. <br>";
                $boxerName = $bout = $koPercent = $status = $titles = $alias = $dob = $nationality = $division = $stance = $height = $reach = $youtubeURL = $star =  $ranking = $win = $lose = $draw = "";
            } else {
                $message = "Record not Inserted, There was a problem. <br>" . mysqli_error($conn) . "</Not>";
            }
        } else {
            $message = "Could not upload <br>";
        }
    }
}
?>

<form method="post" class="container" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" enctype="multipart/form-data">

    <h1 class="display-4 mt-3 mb-5"><?php echo $pageTitle; ?></h1>
    <?php if ($errorMessage != "") : ?>
        <div class="alert alert-danger" role="alert">
            <?php echo $errorMessage; ?>
        </div>
    <?php endif ?>
    <?php if ($successMessage) : ?>
        <div class="alert alert-success" role="alert">
            <?php echo $successMessage; ?>
        </div>
    <?php endif ?>
    <div class="form-group">
        <label for="boxerName">* Boxer Name: </label>
        <input type="text" class="form-control" name="boxerName" id="boxerName" value="<?php echo $boxerName; ?>">
    </div>
    <div class="form-group">
        <label for="bout">* Bout: </label>
        <input type="text" class="form-control " name="bout" id="bout" value="<?php echo $bout; ?>">
    </div>
    <div class="form-group">
        <label for="koPercent">* KO %: </label>
        <input type="text" class="form-control" name="koPercent" id="koPercent" value="<?php echo $koPercent; ?>">
    </div>
    <div class="form-group">
        <label for="status">Status</label>
        <select class="form-control" name="status" id="status">
            <option value="active">Active</option>
            <option value="retired">Retired</option>
        </select>
    </div>
    <div class="form-group">
        <label for="titles">Titles</label>
        <textarea class="form-control" id="titles" name="titles" rows="3"><?php echo $titles; ?></textarea>
    </div>

    <div class="form-group">
        <label for="alias"> Nickname: </label>
        <input type="text" class="form-control" name="alias" id="alias" value="<?php echo $alias; ?>">
    </div>
    <div class="form-group">
        <label for="dob">* Date of Birth: </label>
        <input type="date" class="form-control" name="dob" id="dob" value="<?php echo $dob; ?>">
    </div>
    <div class="form-group">
        <label for="countries">* Country</label>
        <select class="form-control" name="countries" id="countries">
            <option value="">Select a Country</option>
            <option value="Afghanistan" <?php if ($nationality == "Afghanistan") {
                                                            echo 'selected';
                                                        } ?>>Afghanistan</option>

                            <option value="Albania" <?php if ($nationality == "Albania") {
                                                        echo 'selected';
                                                    } ?>>Albania</option>
                            <option value="Algeria" <?php if ($nationality == "Algeria") {
                                                        echo 'selected';
                                                    } ?>>Algeria</option>
                            <option value="American Samoa" <?php if ($nationality == "American Samoa") {
                                                                echo 'selected';
                                                            } ?>>American Samoa</option>
                            <option value="Andorra" <?php if ($nationality == "Andorra") {
                                                        echo 'selected';
                                                    } ?>>Andorra</option>
                            <option value="Angola" <?php if ($nationality == "Angola") {
                                                        echo 'selected';
                                                    } ?>>Angola</option>
                            <option value="Anguilla" <?php if ($nationality == "Anguilla") {
                                                            echo 'selected';
                                                        } ?>>Anguilla</option>
                            <option value="Antartica" <?php if ($nationality == "Antartica") {
                                                            echo 'selected';
                                                        } ?>>Antarctica</option>
                            <option value="antigua-and-barbuda" <?php if ($nationality == "antigua-and-barbuda") {
                                                                    echo 'selected';
                                                                } ?>>Antigua and Barbuda</option>
                            <option value="Argentina" <?php if ($nationality == "Argentina") {
                                                            echo 'selected';
                                                        } ?>>Argentina</option>
                            <option value="Armenia" <?php if ($nationality == "Armenia") {
                                                        echo 'selected';
                                                    } ?>>Armenia</option>
                            <option value="Aruba" <?php if ($nationality == "Aruba") {
                                                        echo 'selected';
                                                    } ?>>Aruba</option>
                            <option value="Australia" <?php if ($nationality == "Australia") {
                                                            echo 'selected';
                                                        } ?>>Australia</option>
                            <option value="Austria" <?php if ($nationality == "Austria") {
                                                        echo 'selected';
                                                    } ?>>Austria</option>
                            <option value="Azerbaijan" <?php if ($nationality == "Azerbaijan") {
                                                            echo 'selected';
                                                        } ?>>Azerbaijan</option>
                            <option value="Bahamas" <?php if ($nationality == "Bahamas") {
                                                        echo 'selected';
                                                    } ?>>Bahamas</option>
                            <option value="Bahrain" <?php if ($nationality == "Bahrain") {
                                                        echo 'selected';
                                                    } ?>>Bahrain</option>
                            <option value="Bangladesh" <?php if ($nationality == "Bangladesh") {
                                                            echo 'selected';
                                                        } ?>>Bangladesh</option>
                            <option value="Barbados" <?php if ($nationality == "Barbados") {
                                                            echo 'selected';
                                                        } ?>>Barbados</option>
                            <option value="Belarus" <?php if ($nationality == "Belarus") {
                                                        echo 'selected';
                                                    } ?>>Belarus</option>
                            <option value="Belgium" <?php if ($nationality == "Belgium") {
                                                        echo 'selected';
                                                    } ?>>Belgium</option>
                            <option value="Belize" <?php if ($nationality == "Belize") {
                                                        echo 'selected';
                                                    } ?>>Belize</option>
                            <option value="Benin" <?php if ($nationality == "Benin") {
                                                        echo 'selected';
                                                    } ?>>Benin</option>
                            <option value="Bermuda" <?php if ($nationality == "Bermuda") {
                                                        echo 'selected';
                                                    } ?>>Bermuda</option>
                            <option value="Bhutan" <?php if ($nationality == "Bhutan") {
                                                        echo 'selected';
                                                    } ?>>Bhutan</option>
                            <option value="Bolivia" <?php if ($nationality == "Bolivia") {
                                                        echo 'selected';
                                                    } ?>>Bolivia</option>
                            <option value="bosnia-and-herzegovina" <?php if ($nationality == "bosnia-and-herzegovina") {
                                                                        echo 'selected';
                                                                    } ?>>Bosnia and Herzegowina</option>
                            <option value="Botswana" <?php if ($nationality == "Botswana") {
                                                            echo 'selected';
                                                        } ?>>Botswana</option>
                            <option value="Bouvet Island" <?php if ($nationality == "Bouvet Island") {
                                                                echo 'selected';
                                                            } ?>>Bouvet Island</option>
                            <option value="Brazil" <?php if ($nationality == "Brazil") {
                                                        echo 'selected';
                                                    } ?>>Brazil</option>
                            <option value="british-indian-ocean-territory" <?php if ($nationality == "british-indian-ocean-territory") {
                                                                                echo 'selected';
                                                                            } ?>>British Indian Ocean Territory</option>
                            <option value="Brunei" <?php if ($nationality == "Brunei") {
                                                        echo 'selected';
                                                    } ?>>Brunei Darussalam</option>
                            <option value="Bulgaria" <?php if ($nationality == "Bulgaria") {
                                                            echo 'selected';
                                                        } ?>>Bulgaria</option>
                            <option value="burkina-faso" <?php if ($nationality == "burkina-faso") {
                                                                echo 'selected';
                                                            } ?>>Burkina Faso</option>
                            <option value="Burundi" <?php if ($nationality == "Burundi") {
                                                        echo 'selected';
                                                    } ?>>Burundi</option>
                            <option value="Cambodia" <?php if ($nationality == "Cambodia") {
                                                            echo 'selected';
                                                        } ?>>Cambodia</option>
                            <option value="Cameroon" <?php if ($nationality == "Cameroon") {
                                                            echo 'selected';
                                                        } ?>>Cameroon</option>
                            <option value="Canada" <?php if ($nationality == "Canada") {
                                                        echo 'selected';
                                                    } ?>>Canada</option>
                            <option value="cape-verde" <?php if ($nationality == "cape-verde") {
                                                            echo 'selected';
                                                        } ?>>Cape Verde</option>
                            <option value="cayman-islands" <?php if ($nationality == "cayman-islands") {
                                                                echo 'selected';
                                                            } ?>>Cayman Islands</option>
                            <option value="central-african-republic" <?php if ($nationality == "central-african-republic") {
                                                                            echo 'selected';
                                                                        } ?>>Central African Republic</option>
                            <option value="Chad" <?php if ($nationality == "Chad") {
                                                        echo 'selected';
                                                    } ?>>Chad</option>
                            <option value="Chile" <?php if ($nationality == "Chile") {
                                                        echo 'selected';
                                                    } ?>>Chile</option>
                            <option value="China" <?php if ($nationality == "China") {
                                                        echo 'selected';
                                                    } ?>>China</option>
                            <option value="christmas-island" <?php if ($nationality == "christmas-island") {
                                                                    echo 'selected';
                                                                } ?>>Christmas Island</option>
                            <option value="cocos-island" <?php if ($nationality == "cocos-island") {
                                                                echo 'selected';
                                                            } ?>>Cocos (Keeling) Islands</option>
                            <option value="Colombia" <?php if ($nationality == "Colombia") {
                                                            echo 'selected';
                                                        } ?>>Colombia</option>
                            <option value="Comoros" <?php if ($nationality == "Comoros") {
                                                        echo 'selected';
                                                    } ?>>Comoros</option>
                            <option value="Congo" <?php if ($nationality == "Congo") {
                                                        echo 'selected';
                                                    } ?>>Congo</option>
                            <option value="democratic-republic-of-congo" <?php if ($nationality == "democratic-republic-of-congo") {
                                                                                echo 'selected';
                                                                            } ?>>Congo, the Democratic Republic of the</option>
                            <option value="cook-islands" <?php if ($nationality == "cook-islands") {
                                                                echo 'selected';
                                                            } ?>>Cook Islands</option>
                            <option value="Costa Rica" <?php if ($nationality == "Costa Rica") {
                                                            echo 'selected';
                                                        } ?>>Costa Rica</option>
                            <option value="ivory-coast" <?php if ($nationality == "ivory-coast") {
                                                            echo 'selected';
                                                        } ?>>Cote d'Ivoire</option>
                            <option value="Croatia" <?php if ($nationality == "Croatia") {
                                                        echo 'selected';
                                                    } ?>>Croatia (Hrvatska)</option>
                            <option value="Cuba" <?php if ($nationality == "Cuba") {
                                                        echo 'selected';
                                                    } ?>>Cuba</option>
                            <option value="Cyprus" <?php if ($nationality == "Cyprus") {
                                                        echo 'selected';
                                                    } ?>>Cyprus</option>
                            <option value="czech-republic" <?php if ($nationality == "czech-republic") {
                                                                echo 'selected';
                                                            } ?>>Czech Republic</option>
                            <option value="Denmark" <?php if ($nationality == "Denmark") {
                                                        echo 'selected';
                                                    } ?>>Denmark</option>
                            <option value="Djibouti" <?php if ($nationality == "Djibouti") {
                                                            echo 'selected';
                                                        } ?>>Djibouti</option>
                            <option value="Dominica" <?php if ($nationality == "Dominica") {
                                                            echo 'selected';
                                                        } ?>>Dominica</option>
                            <option value="dominican-republic" <?php if ($nationality == "dominican-republic") {
                                                                    echo 'selected';
                                                                } ?>>Dominican Republic</option>
                            <option value="east-timor" <?php if ($nationality == "east-timor") {
                                                            echo 'selected';
                                                        } ?>>East Timor</option>
                            <option value="Ecuador" <?php if ($nationality == "Ecuador") {
                                                        echo 'selected';
                                                    } ?>>Ecuador</option>
                            <option value="Egypt" <?php if ($nationality == "Egypt") {
                                                        echo 'selected';
                                                    } ?>>Egypt</option>
                            <option value="El Salvador" <?php if ($nationality == "El Salvador") {
                                                            echo 'selected';
                                                        } ?>>El Salvador</option>
                            <option value="Equatorial Guinea" <?php if ($nationality == "Equatorial Guinea") {
                                                                    echo 'selected';
                                                                } ?>>Equatorial Guinea</option>
                            <option value="Eritrea" <?php if ($nationality == "Eritrea") {
                                                        echo 'selected';
                                                    } ?>>Eritrea</option>
                            <option value="Estonia" <?php if ($nationality == "Estonia") {
                                                        echo 'selected';
                                                    } ?>>Estonia</option>
                            <option value="Ethiopia" <?php if ($nationality == "Ethiopia") {
                                                            echo 'selected';
                                                        } ?>>Ethiopia</option>
                            <option value="Falkland Islands" <?php if ($nationality == "Falkland Islands") {
                                                                    echo 'selected';
                                                                } ?>>Falkland Islands (Malvinas)</option>
                            <option value="Faroe Islands" <?php if ($nationality == "Faroe Islands") {
                                                                echo 'selected';
                                                            } ?>>Faroe Islands</option>
                            <option value="Fiji" <?php if ($nationality == "Fiji") {
                                                        echo 'selected';
                                                    } ?>>Fiji</option>
                            <option value="Finland" <?php if ($nationality == "Finland") {
                                                        echo 'selected';
                                                    } ?>>Finland</option>
                            <option value="France" <?php if ($nationality == "France") {
                                                        echo 'selected';
                                                    } ?>>France</option>
                            <option value="France Metropolitan" <?php if ($nationality == "France Metropolitan") {
                                                                    echo 'selected';
                                                                } ?>>France, Metropolitan</option>
                            <option value="French Guiana" <?php if ($nationality == "French Guiana") {
                                                                echo 'selected';
                                                            } ?>>French Guiana</option>
                            <option value="french-polynesia" <?php if ($nationality == "french-polynesia") {
                                                                    echo 'selected';
                                                                } ?>>French Polynesia</option>
                            <option value="French Southern Territories" <?php if ($nationality == "French Southern Territories") {
                                                                            echo 'selected';
                                                                        } ?>>French Southern Territories</option>
                            <option value="Gabon" <?php if ($nationality == "Gabon") {
                                                        echo 'selected';
                                                    } ?>>Gabon</option>
                            <option value="Gambia" <?php if ($nationality == "Gambia") {
                                                        echo 'selected';
                                                    } ?>>Gambia</option>
                            <option value="Georgia" <?php if ($nationality == "Georgia") {
                                                        echo 'selected';
                                                    } ?>>Georgia</option>
                            <option value="Germany" <?php if ($nationality == "Germany") {
                                                        echo 'selected';
                                                    } ?>>Germany</option>
                            <option value="Ghana" <?php if ($nationality == "Ghana") {
                                                        echo 'selected';
                                                    } ?>>Ghana</option>
                            <option value="Gibraltar" <?php if ($nationality == "Gibraltar") {
                                                            echo 'selected';
                                                        } ?>>Gibraltar</option>
                            <option value="Greece" <?php if ($nationality == "Greece") {
                                                        echo 'selected';
                                                    } ?>>Greece</option>
                            <option value="Greenland" <?php if ($nationality == "Greenland") {
                                                            echo 'selected';
                                                        } ?>>Greenland</option>
                            <option value="Grenada" <?php if ($nationality == "Grenada") {
                                                        echo 'selected';
                                                    } ?>>Grenada</option>
                            <option value="Guadeloupe" <?php if ($nationality == "Guadeloupe") {
                                                            echo 'selected';
                                                        } ?>>Guadeloupe</option>
                            <option value="Guam" <?php if ($nationality == "Guam") {
                                                        echo 'selected';
                                                    } ?>>Guam</option>
                            <option value="Guatemala" <?php if ($nationality == "Guatemala") {
                                                            echo 'selected';
                                                        } ?>>Guatemala</option>
                            <option value="Guinea" <?php if ($nationality == "Guinea") {
                                                        echo 'selected';
                                                    } ?>>Guinea</option>
                            <option value="Guinea-Bissau" <?php if ($nationality == "Guinea-Bissau") {
                                                                echo 'selected';
                                                            } ?>>Guinea-Bissau</option>
                            <option value="Guyana" <?php if ($nationality == "Guyana") {
                                                        echo 'selected';
                                                    } ?>>Guyana</option>
                            <option value="Haiti" <?php if ($nationality == "Haiti") {
                                                        echo 'selected';
                                                    } ?>>Haiti</option>
                            <option value="Heard and McDonald Islands" <?php if ($nationality == "Heard and McDonald Islands") {
                                                                            echo 'selected';
                                                                        } ?>>Heard and Mc Donald Islands</option>
                            <option value="Holy See" <?php if ($nationality == "Holy See") {
                                                            echo 'selected';
                                                        } ?>>Holy See (Vatican City State)</option>
                            <option value="Honduras" <?php if ($nationality == "Honduras") {
                                                            echo 'selected';
                                                        } ?>>Honduras</option>
                            <option value="hong-kong" <?php if ($nationality == "hong-kong") {
                                                            echo 'selected';
                                                        } ?>>Hong Kong</option>
                            <option value="Hungary" <?php if ($nationality == "Hungary") {
                                                        echo 'selected';
                                                    } ?>>Hungary</option>
                            <option value="Iceland" <?php if ($nationality == "Iceland") {
                                                        echo 'selected';
                                                    } ?>>Iceland</option>
                            <option value="India" <?php if ($nationality == "India") {
                                                        echo 'selected';
                                                    } ?>>India</option>
                            <option value="Indonesia" <?php if ($nationality == "Indonesia") {
                                                            echo 'selected';
                                                        } ?>>Indonesia</option>
                            <option value="Iran" <?php if ($nationality == "Iran") {
                                                        echo 'selected';
                                                    } ?>>Iran (Islamic Republic of)</option>
                            <option value="Iraq" <?php if ($nationality == "Iraq") {
                                                        echo 'selected';
                                                    } ?>>Iraq</option>
                            <option value="Ireland" <?php if ($nationality == "Ireland") {
                                                        echo 'selected';
                                                    } ?>>Ireland</option>
                            <option value="Israel" <?php if ($nationality == "Israel") {
                                                        echo 'selected';
                                                    } ?>>Israel</option>
                            <option value="Italy" <?php if ($nationality == "Italy") {
                                                        echo 'selected';
                                                    } ?>>Italy</option>
                            <option value="Jamaica" <?php if ($nationality == "Jamaica") {
                                                        echo 'selected';
                                                    } ?>>Jamaica</option>
                            <option value="Japan" <?php if ($nationality == "Japan") {
                                                        echo 'selected';
                                                    } ?>>Japan</option>
                            <option value="Jordan" <?php if ($nationality == "Jordan") {
                                                        echo 'selected';
                                                    } ?>>Jordan</option>
                            <option value="Kazakhstan" <?php if ($nationality == "Kazakhstan") {
                                                            echo 'selected';
                                                        } ?>>Kazakhstan</option>
                            <option value="Kenya" <?php if ($nationality == "Kenya") {
                                                        echo 'selected';
                                                    } ?>>Kenya</option>
                            <option value="Kiribati" <?php if ($nationality == "Kiribati") {
                                                            echo 'selected';
                                                        } ?>>Kiribati</option>
                            <option value="north-korea" <?php if ($nationality == "north-korea") {
                                                            echo 'selected';
                                                        } ?>>Korea, Democratic People's Republic of</option>
                            <option value="south-korea" <?php if ($nationality == "south-korea") {
                                                            echo 'selected';
                                                        } ?>>Korea, Republic of</option>
                            <option value="Kuwait" <?php if ($nationality == "Kuwait") {
                                                        echo 'selected';
                                                    } ?>>Kuwait</option>
                            <option value="Kyrgyzstan" <?php if ($nationality == "Kyrgyzstan") {
                                                            echo 'selected';
                                                        } ?>>Kyrgyzstan</option>
                            <option value="Lao" <?php if ($nationality == "Lao") {
                                                    echo 'selected';
                                                } ?>>Lao People's Democratic Republic</option>
                            <option value="Latvia" <?php if ($nationality == "Latvia") {
                                                        echo 'selected';
                                                    } ?>>Latvia</option>
                            <option value="Lebanon" <?php if ($nationality == "Lebanon") {
                                                        echo 'selected';
                                                    } ?>>Lebanon</option>
                            <option value="Lesotho" <?php if ($nationality == "Lesotho") {
                                                        echo 'selected';
                                                    } ?>>Lesotho</option>
                            <option value="Liberia" <?php if ($nationality == "Liberia") {
                                                        echo 'selected';
                                                    } ?>>Liberia</option>
                            <option value="Libyan Arab Jamahiriya" <?php if ($nationality == "Libyan Arab Jamahiriya") {
                                                                        echo 'selected';
                                                                    } ?>>Libyan Arab Jamahiriya</option>
                            <option value="Liechtenstein" <?php if ($nationality == "Liechtenstein") {
                                                                echo 'selected';
                                                            } ?>>Liechtenstein</option>
                            <option value="Lithuania" <?php if ($nationality == "Lithuania") {
                                                            echo 'selected';
                                                        } ?>>Lithuania</option>
                            <option value="Luxembourg" <?php if ($nationality == "Luxembourg") {
                                                            echo 'selected';
                                                        } ?>>Luxembourg</option>
                            <option value="Macau" <?php if ($nationality == "Macau") {
                                                        echo 'selected';
                                                    } ?>>Macau</option>
                            <option value="Macedonia" <?php if ($nationality == "Macedonia") {
                                                            echo 'selected';
                                                        } ?>>Macedonia, The Former Yugoslav Republic of</option>
                            <option value="Madagascar" <?php if ($nationality == "Madagascar") {
                                                            echo 'selected';
                                                        } ?>>Madagascar</option>
                            <option value="Malawi" <?php if ($nationality == "Malawi") {
                                                        echo 'selected';
                                                    } ?>>Malawi</option>
                            <option value="Malaysia" <?php if ($nationality == "Malaysia") {
                                                            echo 'selected';
                                                        } ?>>Malaysia</option>
                            <option value="Maldives" <?php if ($nationality == "Maldives") {
                                                            echo 'selected';
                                                        } ?>>Maldives</option>
                            <option value="Mali" <?php if ($nationality == "Mali") {
                                                        echo 'selected';
                                                    } ?>>Mali</option>
                            <option value="Malta" <?php if ($nationality == "Malta") {
                                                        echo 'selected';
                                                    } ?>>Malta</option>
                            <option value="marshall-island" <?php if ($nationality == "marshall-island") {
                                                                echo 'selected';
                                                            } ?>>Marshall Islands</option>
                            <option value="Martinique" <?php if ($nationality == "Martinique") {
                                                            echo 'selected';
                                                        } ?>>Martinique</option>
                            <option value="Mauritania" <?php if ($nationality == "Mauritania") {
                                                            echo 'selected';
                                                        } ?>>Mauritania</option>
                            <option value="Mauritius" <?php if ($nationality == "Mauritius") {
                                                            echo 'selected';
                                                        } ?>>Mauritius</option>
                            <option value="Mayotte" <?php if ($nationality == "Mayotte") {
                                                        echo 'selected';
                                                    } ?>>Mayotte</option>
                            <option value="Mexico" <?php if ($nationality == "Mexico") {
                                                        echo 'selected';
                                                    } ?>>Mexico</option>
                            <option value="Micronesia" <?php if ($nationality == "Micronesia") {
                                                            echo 'selected';
                                                        } ?>>Micronesia, Federated States of</option>
                            <option value="Moldova" <?php if ($nationality == "Moldova") {
                                                        echo 'selected';
                                                    } ?>>Moldova, Republic of</option>
                            <option value="Monaco" <?php if ($nationality == "Monaco") {
                                                        echo 'selected';
                                                    } ?>>Monaco</option>
                            <option value="Mongolia" <?php if ($nationality == "Mongolia") {
                                                            echo 'selected';
                                                        } ?>>Mongolia</option>
                            <option value="Montserrat" <?php if ($nationality == "Montserrat") {
                                                            echo 'selected';
                                                        } ?>>Montserrat</option>
                            <option value="Morocco" <?php if ($nationality == "Morocco") {
                                                        echo 'selected';
                                                    } ?>>Morocco</option>
                            <option value="Mozambique" <?php if ($nationality == "Mozambique") {
                                                            echo 'selected';
                                                        } ?>>Mozambique</option>
                            <option value="Myanmar" <?php if ($nationality == "Myanmar") {
                                                        echo 'selected';
                                                    } ?>>Myanmar</option>
                            <option value="Namibia" <?php if ($nationality == "Namibia") {
                                                        echo 'selected';
                                                    } ?>>Namibia</option>
                            <option value="Nauru" <?php if ($nationality == "Nauru") {
                                                        echo 'selected';
                                                    } ?>>Nauru</option>
                            <option value="Nepal" <?php if ($nationality == "Nepal") {
                                                        echo 'selected';
                                                    } ?>>Nepal</option>
                            <option value="Netherlands" <?php if ($nationality == "Netherlands") {
                                                            echo 'selected';
                                                        } ?>>Netherlands</option>
                            <option value="Netherlands Antilles" <?php if ($nationality == "Netherlands Antilles") {
                                                                        echo 'selected';
                                                                    } ?>>Netherlands Antilles</option>
                            <option value="New Caledonia" <?php if ($nationality == "New Caledonia") {
                                                                echo 'selected';
                                                            } ?>>New Caledonia</option>
                            <option value="new-zealand" <?php if ($nationality == "new-zealand") {
                                                            echo 'selected';
                                                        } ?>>New Zealand</option>
                            <option value="Nicaragua" <?php if ($nationality == "Nicaragua") {
                                                            echo 'selected';
                                                        } ?>>Nicaragua</option>
                            <option value="Niger" <?php if ($nationality == "Niger") {
                                                        echo 'selected';
                                                    } ?>>Niger</option>
                            <option value="Nigeria" <?php if ($nationality == "Nigeria") {
                                                        echo 'selected';
                                                    } ?>>Nigeria</option>
                            <option value="Niue" <?php if ($nationality == "Niue") {
                                                        echo 'selected';
                                                    } ?>>Niue</option>
                            <option value="norfolk-island" <?php if ($nationality == "norfolk-island") {
                                                                echo 'selected';
                                                            } ?>>Norfolk Island</option>
                            <option value="northern-marianas-islands" <?php if ($nationality == "Nigeria") {
                                                                            echo 'selected';
                                                                        } ?>>Northern Mariana Islands</option>
                            <option value="Norway" <?php if ($nationality == "Norway") {
                                                        echo 'selected';
                                                    } ?>>Norway</option>
                            <option value="Oman" <?php if ($nationality == "Oman") {
                                                        echo 'selected';
                                                    } ?>>Oman</option>
                            <option value="Pakistan" <?php if ($nationality == "Pakistan") {
                                                            echo 'selected';
                                                        } ?>>Pakistan</option>
                            <option value="Palau" <?php if ($nationality == "Palau") {
                                                        echo 'selected';
                                                    } ?>>Palau</option>
                            <option value="Panama" <?php if ($nationality == "Panama") {
                                                        echo 'selected';
                                                    } ?>>Panama</option>
                            <option value="papua-new-guinea" <?php if ($nationality == "papua-new-guinea") {
                                                                    echo 'selected';
                                                                } ?>>Papua New Guinea</option>
                            <option value="Paraguay" <?php if ($nationality == "Paraguay") {
                                                            echo 'selected';
                                                        } ?>>Paraguay</option>
                            <option value="Peru" <?php if ($nationality == "Peru") {
                                                        echo 'selected';
                                                    } ?>>Peru</option>
                            <option value="Philippines" <?php if ($nationality == "Philippines") {
                                                            echo 'selected';
                                                        } ?>>Philippines</option>
                            <option value="Pitcairn" <?php if ($nationality == "Pitcairn") {
                                                            echo 'selected';
                                                        } ?>>Pitcairn</option>
                            <option value="Poland" <?php if ($nationality == "Poland") {
                                                        echo 'selected';
                                                    } ?>>Poland</option>
                            <option value="Portugal" <?php if ($nationality == "Portugal") {
                                                            echo 'selected';
                                                        } ?>>Portugal</option>
                            <option value="Puerto Rico" <?php if ($nationality == "Puerto Rico") {
                                                            echo 'selected';
                                                        } ?>>Puerto Rico</option>
                            <option value="Qatar" <?php if ($nationality == "Qatar") {
                                                        echo 'selected';
                                                    } ?>>Qatar</option>
                            <option value="Reunion" <?php if ($nationality == "Reunion") {
                                                        echo 'selected';
                                                    } ?>>Reunion</option>
                            <option value="Romania" <?php if ($nationality == "Romania") {
                                                        echo 'selected';
                                                    } ?>>Romania</option>
                            <option value="Russia" <?php if ($nationality == "Russia") {
                                                        echo 'selected';
                                                    } ?>>Russian Federation</option>
                            <option value="Rwanda" <?php if ($nationality == "Rwanda") {
                                                        echo 'selected';
                                                    } ?>>Rwanda</option>
                            <option value="saint-kitts-and-nevis" <?php if ($nationality == "saint-kitts-and-nevis") {
                                                                        echo 'selected';
                                                                    } ?>>Saint Kitts and Nevis</option>
                            <option value="st-lucia" <?php if ($nationality == "st-lucia") {
                                                            echo 'selected';
                                                        } ?>>Saint LUCIA</option>
                            <option value="st-vincent-and-the-grenadines" <?php if ($nationality == "st-vincent-and-the-grenadines") {
                                                                                echo 'selected';
                                                                            } ?>>Saint Vincent and the Grenadines</option>
                            <option value="Samoa" <?php if ($nationality == "Samoa") {
                                                        echo 'selected';
                                                    } ?>>Samoa</option>
                            <option value="san-marino" <?php if ($nationality == "san-marino") {
                                                            echo 'selected';
                                                        } ?>>San Marino</option>
                            <option value="sao-tome-and-principe" <?php if ($nationality == "sao-tome-and-principe") {
                                                                        echo 'selected';
                                                                    } ?>>Sao Tome and Principe</option>
                            <option value="saudi-arabia" <?php if ($nationality == "saudi-arabia") {
                                                                echo 'selected';
                                                            } ?>>Saudi Arabia</option>
                            <option value="Senegal" <?php if ($nationality == "Senegal") {
                                                        echo 'selected';
                                                    } ?>>Senegal</option>
                            <option value="Seychelles" <?php if ($nationality == "Seychelles") {
                                                            echo 'selected';
                                                        } ?>>Seychelles</option>
                            <option value="sierra-leone" <?php if ($nationality == "sierra-leone") {
                                                        echo 'selected';
                                                    } ?>>Sierra Leone</option>
                            <option value="Singapore" <?php if ($nationality == "Singapore") {
                                                            echo 'selected';
                                                        } ?>>Singapore</option>
                            <option value="Slovakia" <?php if ($nationality == "Slovakia") {
                                                            echo 'selected';
                                                        } ?>>Slovakia (Slovak Republic)</option>
                            <option value="Slovenia" <?php if ($nationality == "Slovenia") {
                                                            echo 'selected';
                                                        } ?>>Slovenia</option>
                            <option value="solomon-islands" <?php if ($nationality == "solomon-islands") {
                                                                echo 'selected';
                                                            } ?>>Solomon Islands</option>
                            <option value="Somalia" <?php if ($nationality == "Somalia") {
                                                        echo 'selected';
                                                    } ?>>Somalia</option>
                            <option value="south-africa" <?php if ($nationality == "south-africa") {
                                                                echo 'selected';
                                                            } ?>>South Africa</option>
                            <option value="South Georgia" <?php if ($nationality == "South Georgia") {
                                                                echo 'selected';
                                                            } ?>>South Georgia and the South Sandwich Islands</option>
                            <option value="spain" <?php if ($nationality == "spain") {
                                                        echo 'selected';
                                                    } ?>>Spain</option>
                            <option value="sri-lanka" <?php if ($nationality == "sri-lanka") {
                                                            echo 'selected';
                                                        } ?>>Sri Lanka</option>
                            <option value="St. Helena" <?php if ($nationality == "St. Helena") {
                                                            echo 'selected';
                                                        } ?>>St. Helena</option>
                            <option value="St. Pierre and Miguelon" <?php if ($nationality == "St. Pierre and Miguelon") {
                                                                        echo 'selected';
                                                                    } ?>>St. Pierre and Miquelon</option>
                            <option value="south-sudan" <?php if ($nationality == "south-sudan") {
                                                            echo 'selected';
                                                        } ?>>South Sudan</option>
                            <option value="Sudan" <?php if ($nationality == "Sudan") {
                                                        echo 'selected';
                                                    } ?>>Sudan</option>
                            <option value="Suriname" <?php if ($nationality == "Suriname") {
                                                            echo 'selected';
                                                        } ?>>Suriname</option>
                            <option value="Svalbard" <?php if ($nationality == "Svalbard") {
                                                            echo 'selected';
                                                        } ?>>Svalbard and Jan Mayen Islands</option>
                            <option value="Swaziland" <?php if ($nationality == "Swaziland") {
                                                            echo 'selected';
                                                        } ?>>Swaziland</option>
                            <option value="Sweden" <?php if ($nationality == "Sweden") {
                                                        echo 'selected';
                                                    } ?>>Sweden</option>
                            <option value="Switzerland" <?php if ($nationality == "Switzerland") {
                                                            echo 'selected';
                                                        } ?>>Switzerland</option>
                            <option value="Syria" <?php if ($nationality == "Syria") {
                                                        echo 'selected';
                                                    } ?>>Syrian Arab Republic</option>
                            <option value="Taiwan" <?php if ($nationality == "Nigeria") {
                                                        echo 'selected';
                                                    } ?>>Taiwan, Province of China</option>
                            <option value="Tajikistan" <?php if ($nationality == "Taiwan") {
                                                            echo 'selected';
                                                        } ?>>Tajikistan</option>
                            <option value="Tanzania" <?php if ($nationality == "Tanzania") {
                                                            echo 'selected';
                                                        } ?>>Tanzania, United Republic of</option>
                            <option value="Thailand" <?php if ($nationality == "Thailand") {
                                                            echo 'selected';
                                                        } ?>>Thailand</option>
                            <option value="Togo" <?php if ($nationality == "Togo") {
                                                        echo 'selected';
                                                    } ?>>Togo</option>
                            <option value="Tokelau" <?php if ($nationality == "Tokelau") {
                                                        echo 'selected';
                                                    } ?>>Tokelau</option>
                            <option value="Tonga" <?php if ($nationality == "Tonga") {
                                                        echo 'selected';
                                                    } ?>>Tonga</option>
                            <option value="trinidad-and-tobago" <?php if ($nationality == "trinidad-and-tobago") {
                                                                    echo 'selected';
                                                                } ?>>Trinidad and Tobago</option>
                            <option value="Tunisia" <?php if ($nationality == "Tunisia") {
                                                        echo 'selected';
                                                    } ?>>Tunisia</option>
                            <option value="Turkey" <?php if ($nationality == "Turkey") {
                                                        echo 'selected';
                                                    } ?>>Turkey</option>
                            <option value="Turkmenistan" <?php if ($nationality == "Turkmenistan") {
                                                                echo 'selected';
                                                            } ?>>Turkmenistan</option>
                            <option value="turks-and-caicos" <?php if ($nationality == "turks-and-caicos") {
                                                                    echo 'selected';
                                                                } ?>>Turks and Caicos Islands</option>
                            <option value="Tuvalu" <?php if ($nationality == "Tuvalu") {
                                                        echo 'selected';
                                                    } ?>>Tuvalu</option>
                            <option value="Uganda" <?php if ($nationality == "Uganda") {
                                                        echo 'selected';
                                                    } ?>>Uganda</option>
                            <option value="Ukraine" <?php if ($nationality == "Ukraine") {
                                                                        echo 'selected';
                                                                    } ?>>Ukraine</option>
                            <option value="united-arab-emirates" <?php if ($nationality == "united-arab-emirates") {
                                                                        echo 'selected';
                                                                    } ?>>United Arab Emirates</option>
                            <option value="united-kingdom" <?php if ($nationality == "united-kingdom") {
                                                                echo 'selected';
                                                            } ?>>United Kingdom</option>
                            <option value="united-states-of-america" <?php if ($nationality == "united-states-of-america") {
                                                                            echo 'selected';
                                                                        } ?>>United States</option>
                            <option value="United States Minor Outlying Islands" <?php if ($nationality == "United States Minor Outlying Islands") {
                                                                                        echo 'selected';
                                                                                    } ?>>United States Minor Outlying Islands</option>
                            <option value="Uruguay" <?php if ($nationality == "Uruguay") {
                                                        echo 'selected';
                                                    } ?>>Uruguay</option>
                            <option value="Uzbekistan" <?php if ($nationality == "Uzbekistan") {
                                                            echo 'selected';
                                                        } ?>>Uzbekistan</option>
                            <option value="Vanuatu" <?php if ($nationality == "Vanuatu") {
                                                        echo 'selected';
                                                    } ?>>Vanuatu</option>
                            <option value="Venezuela" <?php if ($nationality == "Venezuela") {
                                                            echo 'selected';
                                                        } ?>>Venezuela</option>
                            <option value="Vietnam" <?php if ($nationality == "Vietnam") {
                                                        echo 'selected';
                                                    } ?>>Viet Nam</option>
                            <option value="Virgin Islands (British)" <?php if ($nationality == "Virgin Islands (British)") {
                                                                            echo 'selected';
                                                                        } ?>>Virgin Islands (British)</option>
                            <option value="virgin-islands" <?php if ($nationality == "virgin-islands") {
                                                                echo 'selected';
                                                            } ?>>Virgin Islands (U.S.)</option>
                            <option value="Wallis and Futana Islands" <?php if ($nationality == "Wallis and Futana Islands") {
                                                                            echo 'selected';
                                                                        } ?>>Wallis and Futuna Islands</option>
                            <option value="western-sahara" <?php if ($nationality == "western-sahara") {
                                                                echo 'selected';
                                                            } ?>>Western Sahara</option>
                            <option value="Yemen" <?php if ($nationality == "Yemen") {
                                                        echo 'selected';
                                                    } ?>>Yemen</option>
                            <option value="Yugoslavia" <?php if ($nationality == "Yugoslavia") {
                                                            echo 'selected';
                                                        } ?>>Yugoslavia</option>
                            <option value="Zambia" <?php if ($nationality == "Zambia") {
                                                        echo 'selected';
                                                    } ?>>Zambia</option>
                            <option value="Zimbabwe" <?php if ($nationality == "Zimbabwe") {
                                                            echo 'selected';
                                                        } ?>>Zimbabwe</option>
        </select>
    </div>
    <div class="form-group">
        <label for="division">* Division</label>
        <select class="form-control" name="division" id="division">
            <option value="">Select a Division</option>
            <option value="Heavyweight" <?php if ($division == "Heavyweight") {
                                                            echo 'selected';
                                                        } ?>>Heavyweight</option>
                            <option value="Cruiserweight" <?php if ($division == "Cruiserweight") {
                                                                echo 'selected';
                                                            } ?>>Cruiserweight</option>
                            <option value="Light heavyweight" <?php if ($division == "Light heavyweight") {
                                                                    echo 'selected';
                                                                } ?>>Light heavyweight</option>
                            <option value="Super middleweight" <?php if ($division == "Super middleweight") {
                                                                    echo 'selected';
                                                                } ?>>Super middleweight</option>
                            <option value="Middleweight" <?php if ($division == "Middleweight") {
                                                                echo 'selected';
                                                            } ?>>Middleweight</option>
                            <option value="Super welterweight" <?php if ($division == "Super welterweight") {
                                                                    echo 'selected';
                                                                } ?>>Super welterweight</option>
                            <option value="Welterweight" <?php if ($division == "Welterweight") {
                                                                echo 'selected';
                                                            } ?>>Welterweight</option>
                            <option value="Super lightweight" <?php if ($division == "Super lightweight") {
                                                                    echo 'selected';
                                                                } ?>>Super lightweight</option>
                            <option value="Lightweight" <?php if ($division == "Lightweight") {
                                                            echo 'selected';
                                                        } ?>>Lightweight</option>
                            <option value="Super featherweight" <?php if ($division == "Super featherweight") {
                                                                    echo 'selected';
                                                                } ?>>Super featherweight</option>
                            <option value="Featherweight" <?php if ($division == "Featherweight") {
                                                                echo 'selected';
                                                            } ?>>Featherweight</option>
                            <option value="Super bantamweight" <?php if ($division == "Super bantamweight") {
                                                                    echo 'selected';
                                                                } ?>>Super bantamweight</option>
                            <option value="Bantamweight" <?php if ($division == "Bantamweight") {
                                                                echo 'selected';
                                                            } ?>>Bantamweight</option>
                            <option value="Super flyweight" <?php if ($division == "Super flyweight") {
                                                                echo 'selected';
                                                            } ?>>Super flyweight</option>
                            <option value="Flyweight" <?php if ($division == "Flyweight") {
                                                            echo 'selected';
                                                        } ?>>Flyweight</option>
                            <option value="Light flyweight" <?php if ($division == "Light flyweight") {
                                                                echo 'selected';
                                                            } ?>>Light flyweight</option>
                            <option value="Minimumweight" <?php if ($division == "Minimumweight") {
                                                                echo 'selected';
                                                            } ?>>Minimumweight</option>
                            <option value="Light minimumweight" <?php if ($division == "Light minimumweight") {
                                                                    echo 'selected';
                                                                } ?>>Light minimumweight</option>
        </select>
    </div>
    <div class="form-group">
        <label for="stance">* Stance</label>
        <select class="form-control" name="stance" id="stance">
            <option value="">Select a Stance</option>
            <option value="orthodox" <?php if ($stance == "orthodox") {
                                                            echo 'selected';
                                                        } ?>>Orthodox</option>
                            <option value="southpaw" <?php if ($stance == "southpaw") {
                                                            echo 'selected';
                                                        } ?>>Southpaw</option>
        </select>
    </div>
    <div class="form-group">
        <label for="height"> Height: </label>
        <input type="text" class="form-control" placeholder="Height in cm" name="height" id="height" value="<?php echo $height; ?>">
    </div>
    <div class="form-group">
        <label for="reach"> Reach: </label>
        <input type="text" class="form-control" placeholder="Reach in cm" name="reach" id="reach" value="<?php echo $reach; ?>">
    </div>

    <div class="form-group">
        <label for="boxerPic">* Choose Boxer Image</label>
        <input type="file" class="form-control-file" name="boxerPic" id="boxerPic">
    </div>
    <div class="form-group">
        <label for="youtubeURL"> Highlight Video Link: </label>
        <input type="text" class="form-control" name="youtubeURL" id="youtubeURL" value="<?php echo $youtubeURL; ?>">
    </div>
    <div class="form-group">
        <label for="star"> Star: </label>
        <input type="text" class="form-control" name="star" placeholder="Example: 4.5" id="star" value="<?php echo $star; ?>">
    </div>
    <div class="form-group">
        <label for="ranking"> Ranking: </label>
        <input type="text" class="form-control" placeholder="Example: 35" name="ranking" id="ranking" value="<?php echo $ranking; ?>">
    </div>
    <div class="form-group">
        <label for="win">* Win: </label>
        <input type="text" class="form-control" name="win" id="win" value="<?php echo $win; ?>">
    </div>
    <div class="form-group">
        <label for="lose">* Lose: </label>
        <input type="text" class="form-control" name="lose" id="lose" value="<?php echo $lose; ?>">
    </div>
    <div class="form-group">
        <label for="draw">* Draw: </label>
        <input type="text" class="form-control" name="draw" id="draw" value="<?php echo $draw; ?>">
    </div>
    <div class="mt-5 mb-5">
        <input type="submit" name="submit" value="Submit!" class="btn btn-primary col-4 offset-4">
    </div>




</form>
<?php
include("../inc/footer.php");
?>