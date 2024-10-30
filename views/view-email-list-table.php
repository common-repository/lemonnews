<?php foreach ($emailsList as $item) : ?>
<tr>
    <td><?php echo $item->id; ?></td>
    <td><?php echo $item->date_created; ?></td>
	<td><?php echo (empty($item->date_modified)) ? '--' : $item->date_modified; ?></td>
    <td><a href="#" class="ttip btn-edit" data-toggle="tooltip" title="<?php echo __("Click here to edit this e-mail address", "LemonNewsDomain"); ?>" name="edit-<?php echo $item->id; ?>"><?php echo $item->email; ?></a></td>
    <td><a href="#" class="ttip btn btn-mini btn-danger btn-delete" data-toggle="tooltip" title="<?php echo __("Click here to remove this record", "LemonNewsDomain"); ?>" name="delete-<?php echo $item->id; ?>" ><i class="icon icon-remove icon-white"></i></a></td>
</tr>
<?php endforeach; ?>