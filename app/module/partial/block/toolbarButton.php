<button id="toolbarToggle" state="0" type="button" class="navbar-toggle collapsed toolbarToggle"
    data-toggle="collapse" data-target="#toolbar">
    <a id="toolbarToggleLink" href="" class="btn btn-primary">
        <?php echo $l["global"]["toolbar"]["button"]["show"]; ?>
    </a>
</button>

<script type="text/javascript">
//<![CDATA[

$(document).ready(function(e) {
    var toolbarButton = $("#toolbarToggle");

    toolbarButton.click(function(e) {
        var toolbarLink = $("#toolbarToggleLink");

        if (toolbarButton.attr("state") == 0) {
            toolbarLink.html("<?php echo $l["global"]["toolbar"]["button"]["hide"]; ?>");
            toolbarButton.attr("state", 1);
        } else {
            toolbarLink.text("<?php echo $l["global"]["toolbar"]["button"]["show"]; ?>");
            toolbarButton.attr("state", 0);
        }
    });
});

//]]>
</script>
