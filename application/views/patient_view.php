<?php  foreach($rows as $row); ?>
<table class="table table-bordered table-responsive">
    <thead>
    <tr>
    <th>First Name</th>
    <th>Last Name</th>
    </tr>
    </thead>
    <tbody>
<tr>
    <td><?php echo $row->patient_fname; ?></td>
</tr></tbody>
</table>
