<?php
$proj_id = $project['id'];
$points = ProjectenPoint::findBy(['projecten_id' => $proj_id]);
