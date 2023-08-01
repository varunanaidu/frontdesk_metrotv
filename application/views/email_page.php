<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php
$title = $email['title'];
$content = $email['content'];
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>FRONTDESK APPLICATION</title>
</head>

<body style="background:#ecf0f5;font-family:'Segoe UI', Arial, Tahoma;font-size:1em;">
	<div style="height:100%;max-width:500px;margin:0 auto;">
		<div style="margin:50px 0px;">
			<div style="background:#FFF;padding:25px;box-shadow:0px 0px 8px 5px grey;">
				<div style="background:#EEE;padding:20px;margin-auto;text-align:center;">
					<div style="font-weight:normal;color:navy;letter-spacing:4px;"><?= $title ?></div>
				</div>
				<hr>
				<div>
					<div>
						<h2 style="margin-top:0"><?= ist($title) ?></h2>
					</div>
				</div>
				<div>
					<div style="font-size:0.8em;padding:0 20px;font-weight:500;">
						<table style="margin-top:5px;margin-bottom:5px;">
							<tr style="line-height:1.5em;">
								<td style="width:100px;vertical-align:top;">Nama</td>
								<td style="width:10px;vertical-align:top;">:</td>
								<td><?= ist($content->name) ?></td>
							</tr>
							<tr style="line-height:1.5em;">
								<td style="width:100px;vertical-align:top;">No. KTP</td>
								<td style="width:10px;vertical-align:top;">:</td>
								<td><?= ist($content->identityNo) ?></td>
							</tr>
							<tr style="line-height:1.5em;">
								<td style="width:100px;vertical-align:top;">No. Handphone</td>
								<td style="width:10px;vertical-align:top;">:</td>
								<td><?= ist($content->phone) ?></td>
							</tr>
							<tr style="line-height:1.5em;">
								<td style="width:100px;vertical-align:top;">Alamat</td>
								<td style="width:10px;vertical-align:top;">:</td>
								<td><?= ist($content->address) ?></td>
							</tr>
							<tr style="line-height:1.5em;">
								<td style="width:100px;vertical-align:top;">Keperluan</td>
								<td style="width:10px;vertical-align:top;">:</td>
								<td><?= ist($content->purpose) ?></td>
							</tr>
							<tr style="line-height:1.5em;">
								<td style="width:100px;vertical-align:top;">Lokasi</td>
								<td style="width:10px;vertical-align:top;">:</td>
								<td><?= ist($content->location_name) ?></td>
							</tr>
							<tr style="line-height:1.5em;">
								<td style="width:100px;vertical-align:top;">Jumlah Tamu</td>
								<td style="width:10px;vertical-align:top;">:</td>
								<td><?= ist($content->total_guest) ?></td>
							</tr>
						</table>
					</div>
					<div style="margin-top:20px;font-weight:bold;text-align:center;color:black">
						<hr />
						<img src="<?= base_url(ist($content->identityPhoto)) ?>">
						<img src="<?= base_url(ist($content->photo)) ?>">
					</div>
					<div style="margin-top:5px;font-size:0.9em;text-align:center"><em>This is an automatically generated email. Please DO NOT REPLY.</em></div>
				</div>
				<div style="text-align:center;margin-top:10px;font-size:0.8em;color:black">
					<strong>Copyright &copy; <?= date('Y') ?> <?= 'Media Group' ?>. All rights reserved.</strong>
				</div>
			</div>
		</div>
	</div>
</body>

</html>