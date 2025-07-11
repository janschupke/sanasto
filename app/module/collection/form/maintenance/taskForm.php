<form id="maintenanceTaskForm" class="form-horizontal" method="post" action="<?php echo $defaultFormTarget; ?>">
    <input type="hidden" name="csrfToken" value="<?php echo $_SESSION["newCsrfToken"]; ?>" />
    <input type="hidden" name="collectionOperation" value="maintenanceTask" />
    <fieldset>
        <div class="form-group">
            <div class="col-xs-12">
                <p><?php echo $l["form"]["collection"]["maintenance"]["taskSelection"]["label"]; ?></p>
            </div>
        </div>

        <div class="form-group errorMessage maintenancePasswordError">
            <div class="col-xs-12 text-danger">
                <?php echo $l["form"]["collection"]["maintenance"]["taskSelection"]["passwordError"]; ?>
            </div>
        </div>

        <div class="form-group">
            <div class="col-xs-12">
                <input type="password" class="form-control" autocomplete="off"
                    name="maintenancePassword" id="maintenancePassword"
                    placeholder="<?php echo $l["form"]["collection"]["maintenance"]["taskSelection"]["password"]; ?>" />
            </div>
        </div>

        <div class="form-group errorMessage maintenanceTaskError">
            <div class="col-xs-12 text-danger">
                <?php echo $l["form"]["collection"]["maintenance"]["taskSelection"]["taskError"]; ?>
            </div>
        </div>

        <div class="form-group">
            <div class="col-xs-12">
                <?php $checked = FormUtils::determineCheckedRadio($_POST["taskType"], MaintenanceController::TASK_UNPRIORITIZE); ?>
                <input type="radio"
                    class="form-control css-radio"
                    name="taskType"
                    id="taskType<?php echo MaintenanceController::TASK_UNPRIORITIZE; ?>"
                    <?php echo $checked; ?>
                    value="<?php echo MaintenanceController::TASK_UNPRIORITIZE; ?>" />

                <label for="taskType<?php echo MaintenanceController::TASK_UNPRIORITIZE; ?>" class="css-radio-label">
                    <?php echo $l["form"]["collection"]["maintenance"]["taskSelection"]["unprioritize"]["label"]; ?>
                </label>
            </div>
        </div>

        <div class="form-group maintenanceDetail" id="unprioritizeDetail">
            <div class="col-xs-12">
                    <?php
                    echo sprintf($l["form"]["collection"]["maintenance"]["taskSelection"]["unprioritize"]["message"],
                        '<span class="text-danger">' . Utility::getNiceNumber($prioritizedCount) . '</span>');
                    ?>
            </div>
        </div>

        <div class="form-group">
            <div class="col-xs-12">
                <?php $checked = FormUtils::determineCheckedRadio($_POST["taskType"], MaintenanceController::TASK_SET_UNKNOWN); ?>
                <input type="radio"
                    class="form-control css-radio"
                    name="taskType"
                    id="taskType<?php echo MaintenanceController::TASK_SET_UNKNOWN; ?>"
                    <?php echo $checked; ?>
                    value="<?php echo MaintenanceController::TASK_SET_UNKNOWN; ?>" />

                <label for="taskType<?php echo MaintenanceController::TASK_SET_UNKNOWN; ?>" class="css-radio-label">
                    <?php echo $l["form"]["collection"]["maintenance"]["taskSelection"]["setUnknown"]["label"]; ?>
                </label>
            </div>
        </div>

        <div class="form-group maintenanceDetail" id="setUnknownDetail">
            <div class="col-xs-12">
                    <?php
                    echo sprintf($l["form"]["collection"]["maintenance"]["taskSelection"]["setUnknown"]["message"],
                        '<span class="text-danger">' . Utility::getNiceNumber($knownCount) . '</span>');
                    ?>
            </div>
        </div>

        <div class="form-group">
            <div class="col-xs-12">
                <?php $checked = FormUtils::determineCheckedRadio($_POST["taskType"], MaintenanceController::TASK_WIPE_DB); ?>
                <input type="radio"
                    class="form-control css-radio"
                    name="taskType"
                    id="taskType<?php echo MaintenanceController::TASK_WIPE_DB; ?>"
                    <?php echo $checked; ?>
                    value="<?php echo MaintenanceController::TASK_WIPE_DB; ?>" />

                <label for="taskType<?php echo MaintenanceController::TASK_WIPE_DB; ?>" class="css-radio-label">
                    <?php echo $l["form"]["collection"]["maintenance"]["taskSelection"]["wipeDb"]["label"]; ?>
                </label>
            </div>
        </div>

        <div class="form-group maintenanceDetail" id="wipeDbDetail">
            <div class="col-xs-12">
                    <?php
                    echo sprintf($l["form"]["collection"]["maintenance"]["taskSelection"]["wipeDb"]["message"],
                        '<span class="text-danger">' . Utility::getNiceNumber($wordCount) . '</span>',
                        '<span class="text-danger">' . Utility::getNiceNumber($translationCount) . '</span>',
                        '<span class="text-danger">' . Utility::getNiceNumber($languageCount) . '</span>');
                    ?>
            </div>
        </div>

        <div class="form-group">
            <div class="col-xs-12">
                <div class="pull-right">
                    <button type="submit" class="btn btn-danger">
                        <?php echo $l["form"]["collection"]["maintenance"]["taskSelection"]["submit"]; ?>
                    </button>
                </div>
            </div>
        </div>
    </fieldset>
</form>

<script type="text/javascript">
//<![CDATA[

$(document).on('submit','#maintenanceTaskForm',function(e) {
    var passed = true;

    if ($('#maintenancePassword').val().length === 0) {
        $('.maintenancePasswordError').fadeIn();
        passed = false;
    } else {
        $('.maintenancePasswordError').fadeOut();
    }

    if ($('input[name=taskType]').filter(':checked').val() == null) {
        $('.maintenanceTaskError').fadeIn();
        passed = false;
    } else {
        $('.maintenanceTaskError').fadeOut();
    }

    if (!passed) {
        return false;
    }

    return true;
});

$(document).ready(function() {
    $('input[name=taskType]').on('change', function() {
        if ($('input[name=taskType]').filter(':checked').val()
                === '<?php echo MaintenanceController::TASK_UNPRIORITIZE; ?>') {
            $('#unprioritizeDetail').fadeIn();

            $('#setUnknownDetail').fadeOut();
            $('#wipeDbDetail').fadeOut();
        }

        if ($('input[name=taskType]').filter(':checked').val()
                === '<?php echo MaintenanceController::TASK_SET_UNKNOWN; ?>') {
            $('#setUnknownDetail').fadeIn();

            $('#unprioritizeDetail').fadeOut();
            $('#wipeDbDetail').fadeOut();
        }

        if ($('input[name=taskType]').filter(':checked').val()
                === '<?php echo MaintenanceController::TASK_WIPE_DB; ?>') {
            $('#wipeDbDetail').fadeIn();

            $('#setUnknownDetail').fadeOut();
            $('#unprioritizeDetail').fadeOut();
        }
    });
});

//]]>
</script>
