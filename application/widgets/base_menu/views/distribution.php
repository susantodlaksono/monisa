<div id="<?php echo $unixid; ?>" class="row">
    <?php
    foreach ($menu as $k => $v) {
        ?>
        <div class="col-md-4">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="panel-title">
                        <?php echo $v['name'] ?>
                    </div>
                    <div class="panel-options">
                        <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                    </div>
                </div>
                <div class="panel-body" style="height: <?php echo $k ? '400px' : 'calc(400px - 63px)'; ?>">
                    <div id="list-<?php echo $k; ?>" class="nested-list dd with-margins">
                        <?php
                        echo $v['menu'];
                        ?>
                    </div>
                </div>
                <?php
                if(!$k){
                    ?>
                    <div class="panel-footer">
                        <button class="btn btn-primary btn-block btn-lg" data-toggle="modal" data-target="#add-menu-modal-<?php echo $unixid; ?>">ADD MENU</button>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
        <?php
    }
    ?>
</div>
<div id="add-menu-modal-<?php echo $unixid; ?>" class="modal fade">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">
                    <i class="entypo-menu"></i>
                    Add Menu
                </h4>
            </div>
            <div class="modal-body">
                
            </div>
            <div class="modal-footer">
                <a href="#" class="btn btn-default" data-dismiss="modal">Close</a>
                <button class="btn btn-primary">Save</button>
            </div>
        </div>
    </div>
</div>
<script>
    var unixid = <?php echo $unixid ?>;
</script>