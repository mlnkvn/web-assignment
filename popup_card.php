<div id="shadowed-back">
    <?php
    if (isset($_GET['cat'])) {
        $cats = explode("_", $_GET['cat']);
        $category = $cats[0];
        $subcategory = $cats[1];
        $id = explode("_", $cats[2])[0];
    }
    $item = getItemWithId($con, $id);


    ?>
    <script>
        var displayed_items = document.getElementsByClassName("item-container-class");
        for (let i = 0; i < displayed_items.length; i++) {
            displayed_items[i].disable();
        }
    </script>

    <div class="pop-up-container">
        <script type="text/javascript">
            const item = <?php echo json_encode($item); ?>;

            function setImgSrc() {
                if (location.href.search('#') !== -1) {
                    return "../img/" + item[6];
                }
                return "";
            }

            function getPrevHref() {
                const prevUrl = document.location.href.split('_');
                return prevUrl[0] + '_' + prevUrl[1];
            }
        </script>
        <a href="javascript:document.location.href=getPrevHref();" class="close-button">x</a>
        <div class="item-image">
            <img src="../img/card50.png" onload="this.onload=null; this.src=setImgSrc()" id="item-img-img"
                 style="width: 80%; height: auto;"
                 alt="There is no picture for this product"/>
        </div>
        <div class="slideshow-buttons">
            <div class="one"></div>
            <div class="two"></div>
            <div class="three"></div>
            <div class="four"></div>
        </div>
        <form method="post" id="buyingForm" action="#" onsubmit="setFormUrl()">
            <script>
                function setFormUrl() {
                    const url = "../actions/addingToCart.php?" + location.href.split('?')[1].split('#')[0];
                    document.getElementById('buyingForm').setAttribute('action', url);
                }
            </script>
            <p class="pick">choose size</p>
            <div class="sizes">
                <?php $chosenSize = -1 ?>
                <button type="button" name="size1" class="size" onclick="pickSize(0)"
                        >32-35</button>
                <button type="button" name="size2" class="size" onclick="pickSize(1)"
                        >36-39</button>
                <button type="button" name="size3" class="size" onclick="pickSize(2)"
                        >40-45</button>
                <button type="button" name="size4" class="size" onclick="pickSize(3)"
                        >46+</button>
                <script>
                    function pickSize(ind) {
                        const sizeButtons = document.getElementsByClassName("size");
                        for (let i = 0; i < sizeButtons.length; i++) {
                            if (i === ind) {
                                sizeButtons[i].classList.add('focus');
                                continue;
                            }
                            sizeButtons[i].classList.remove('focus');
                        }
                        if (ind === 0) {
                            <?php $_POST[] = "size1"; ?>
                        } else if (ind === 1) {
                            <?php $_POST[] = "size2"; ?>
                        } else if (ind === 2) {
                            <?php $_POST[] = "size3"; ?>
                        } else {
                            <?php $_POST[] = "size4"; ?>
                        }
                    }
                </script>
            </div>


            <div class="product">
                <p id="item-category"></p>
                <h1 id="item-prod-name"></h1>
                <h2 id="item-prod-price">$150</h2>
                <p class="desc" id="item-prod-desc"></p>
                <div class="buttons">
                    <button class="add" type="submit" name="submit">Add to Cart</button>
                </div>
            </div>
            <script>
                if (location.href.search('#') !== -1) {
                    document.getElementById("item-category").innerHTML = item[1].toUpperCase();
                    document.getElementById("item-prod-name").innerHTML = item[3];
                    document.getElementById("item-prod-price").innerHTML = item[4] + '€';
                    document.getElementById("item-prod-desc").innerHTML = item[7];
                }
            </script>
        </form>
    </div>

</div>
