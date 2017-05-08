<!DOCTYPE html>
<html>
<body>
	<table style="max-width: 600px;">
		<tr>
			<td>
				<table width="100%">
					<tr>
						<td>Name</td>
						<td>:</td>
						<td>{{ $data['name'] }}</td>
					</tr>
					<tr>
						<td>Email</td>
						<td>:</td>
						<td>{{ $data['email'] }}</td>
					</tr>
					<tr>
						<td>Message</td>
						<td>:</td>
						<td>{{ $data['message'] }}</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
</body>
</html>
