<div class="modal fade" id="languageModal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"
                        aria-label="<?php echo $l["global"]["aria"]["close"]; ?>"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><?php echo $l["modal"]["language"]["title"]; ?></h4>
            </div>

            <div class="modal-body">
                <ul>
                <?php foreach (ConfigValues::getLanguages() as $key => $value) {
                    echo "<li><a href=\"?language=" . $value[0] . "\">" . $value[1] . "</a></li>";
                } ?>
                </ul>
            </div>

            <div class="modal-footer">
                <a href="#" class="btn btn-default" data-dismiss="modal"><?php echo $l["global"]["cancel"]; ?></a>
            </div>
        </div>
    </div>
</div>
