<?php
?>
<ul class="nav nav-tabs nav-justified">
    <li class=""><a href="#stats" data-toggle="tab" aria-expanded="false">Stats</a></li>
    <li class=""><a href="#time" data-toggle="tab" aria-expanded="false">Time</a></li>
    <li class="active"><a href="#profile" data-toggle="tab" aria-expanded="false">Full-list</a></li>
</ul>
<div id="myTabContent" class="tab-content">
    <div class="tab-pane fade" id="stats">
        <?php include_once '../../yves-rocher/stats.php'; ?>
    </div>
    <div class="tab-pane fade" id="time">
    </div>
    <div class="tab-pane fade" id="dropdown1">
    </div>
    <div class="tab-pane fade active in" id="dropdown2">
    </div>
</div>