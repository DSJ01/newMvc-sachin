<?php
echo "<pre>";
$rows = $this->getCollection()->getData();
$url = new Model_Core_Url();
print_r($this->getCollumns());
// die();
?>
	<div class="dis-1">
		<div class="dis-1a"> PAYMENT SHIPPING</div>
		<div class="dis-1a"> <button> <a href=<?php echo $url->getUrl('payment','add');?>> ADD PAYMENT</a> </button> </div>
	</div>
	<?php if (!$rows) {
		echo "Data not found";
	} ?>
	<table class="table table-sm">
		<tr>
		<th>PAYMENT ID</th>
		<th>NAME</th>
		<th>STATUS</th>
		<th>EDIT</th>
		<th>DELETE</th>
		</tr>
		<?php
			foreach ($rows as $row):
		?>
		<tr>
			<?php foreach ($this->getCollumns() as $key => $name): ?>
		<td><?php echo  $this->getCollumnValue($key,$row) ?> </td>
			<?php  endforeach; ?>
		<td> <a href=<?php echo $url->getUrl('payment','edit',['id' => $row-> payment_method_id]);?>>EDIT</a> </td>
		<td> <a href=<?php echo $url->getUrl('payment','delete',['id' => $row-> payment_method_id]);?>>DELETE</a> </td>
		</tr>
	<?php endforeach; ?>
	</table>
