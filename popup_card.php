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

    <div class="pop-up-container" >
        <script type="text/javascript">
            const item = <?php echo json_encode($item); ?>;
            function setImgSrc() {
                console.log(item);
                return "../img/" + item[6];
            }
            function getPrevHref() {
                const prevUrl = document.location.href.split('_');
                return prevUrl[0] + '_' + prevUrl[1];
            }
        </script>
        <a href="javascript:document.location.href=getPrevHref();" class="close-button" >x</a>
        <div class="item-image">
            <img src="../img/card50.png" onload="this.onload=null; this.src=setImgSrc()" id="item-img-img" style="width: 80%; height: auto;"
                 alt="There is no picture for this product"/>
        </div>
        <div class="slideshow-buttons">
            <div class="one"></div>
            <div class="two"></div>
            <div class="three"></div>
            <div class="four"></div>
        </div>
        <form method="post" action="javascript:addToCart()">
            <p class="pick">choose size</p>
            <div class="sizes">
                <input type="button" class="size" onclick="pickSize(0)" value="32-35">
                <input type="button"  class="size" onclick="pickSize(1); <?php $chosenSize = 1 ?>" value="36-49">
                <input type="button"  class="size" onclick="pickSize(2); <?php $chosenSize = 2 ?>" value="40-45">
                <input type="button"  class="size" onclick="pickSize(3); <?php $chosenSize = 3 ?>" value="46+">
                <script>
                    function pickSize(ind) {
                        var sizeButtons = document.getElementsByClassName("size");
                        for (let i = 0; i < sizeButtons.length; i++) {
                            if (i === ind) {
                                sizeButtons[i].classList.add('focus');
                                continue;
                            }
                            sizeButtons[i].classList.remove('focus');
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
                    <button class="add" type="submit">Add to Cart</button>
                </div>
            </div>
            <script>
                document.getElementById("item-category").innerHTML = item[1].toUpperCase();
                document.getElementById("item-prod-name").innerHTML = item[3];
                document.getElementById("item-prod-price").innerHTML = item[4] + '€';
                document.getElementById("item-prod-desc").innerHTML = item[7];
            </script>
        </form>
    </div>

</div>

<script>

    function addToCart() {
        console.log('<?php echo json_encode($_GET); ?>');
    }
</script>