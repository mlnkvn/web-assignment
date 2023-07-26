<?php
include_once 'header_admin.php';
?>
<script>
    console.log();
</script>
    <div class="post-settings" align="center" style="padding-top: 8%;">
        <h2 class="h3 mb-4 page-title">Post Info</h2>
        <p style="display: inline;" id="error-msg"><?php
            if (isset($_GET["error"])) {
                echo '<script> showError(); </script>';
                if ($_GET["error"] == "stmtfailed") {
                    echo "Something went wrong. Try again later.";
                } else if ($_GET["error"] == "none") {
                    echo "Post was sockcessfully added!";
                }
            } else {
                echo '<script> hideError(); </script>';
            }
            ?></p>
        <div class="row justify-content-center">
            <div class="col-12 col-lg-10 col-xl-8 mx-auto">
                <div class="my-4">
                    <form method="post" onsubmit="checkPostForm()" action="../actions/addpostscript.php">
                        <hr class="my-4"/>
                        <div class="form-group">
                            <label for="postTitle">Post Title<img src="../img/error-img.png" alt="Oops!"
                                                                  id="error-postTitle"
                                                                  style="width: 6%; visibility: hidden;"></label>
                            <input type="text" id="postTitle" name="postTitle" class="form-control"/>
                        </div>
                        <div class="form-group">
                            <label for="postPicLink">Link to Post Image<img src="../img/error-img.png" alt="Oops!"
                                                                            id="error-postPicLink"
                                                                            style="width: 6%; visibility: hidden;"></label>
                            <input type="text" class="form-control" id="postPicLink" name="postPicLink"/>
                        </div>
                        <div class="form-group">
                            <label for="postText">Post Text<img src="../img/error-img.png" alt="Oops!"
                                                                id="error-postText"
                                                                style="width: 6%; visibility: hidden;"></label>
                            <input type="text" class="form-control" id="postText" name="postText"/>
                        </div>
                        <hr class="my-4"/>
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="postCategory">
                                    <label for="postCategory">Post Category</label>
                                    <select class="form-control" name="postCategory" id="postCategory">
                                        <option value="NULL" id="opt_null">NULL</option>
                                        <option value="pattern" id="opt_pattern">Socks with patterns</option>
                                        <option value="memes" id="opt_memes">Socks with memes</option>
                                        <option value="basic" id="opt_basic">Basic Socks</option>
                                        <option value="headwear" id="opt_headwear">Headwear</option>
                                        <option value="card" id="opt_card">Gift Cards</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="postDate">Post Date<img src="../img/error-img.png" alt="Oops!"
                                                                    id="error-postDate"
                                                                    style="width: 6%; visibility: hidden;"></label>

                                <input type="date" class="form-control" id="postDate" name="postDate" value=""/>
                                <script>
                                    document.getElementById("postDate").value = new Date().toISOString().substring(0,10);
                                </script>
                            </div>
                        </div>
                        <input type="submit" name="add-post-submit" value="Add post"/>
                    </form>
                </div>
            </div>
        </div>
    </div>

<?php
include_once '../footer.php';
?>