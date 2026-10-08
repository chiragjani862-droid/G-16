<?php
include("conn.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php
    $select = "select * from hero_section";
    $r = mysqli_query($conn, $select);
    ?>
    <section class="hero">
        <div class="hero__slider owl-carousel">
                        <?php
                        foreach ($r as $value) {
                            echo '
            <div class="hero__items set-bg" data-setbg="./admin_panel/images/'.$value['img'].'">
            
                <div class="container">
                    <div class="row">
                                <div class="col-xl-5 col-lg-7 col-md-8">
                                    <div class="hero__text">
                                        <h2>'.$value['name'].'</h2>
                                        <p>'.$value['description'].'</p>
                                      
                                    </div>
                                </div>
                                
                                </div>
                                </div>
                                </div>
                                ';
                            }
                ?>
        
        </div>

    </section>

</body>

</html>