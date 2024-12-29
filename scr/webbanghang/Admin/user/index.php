<?php
    $title = 'Quản Lý Người Dùng';
    $baseUrl = '../';
    require_once('../layout/header.php');

    $sql = "SELECT user.*, role.name AS role_name FROM user LEFT JOIN role ON user.role_id = role.id WHERE user.deleted = 0";
    $data = executeResult($sql);
    
 ?>

 <div class="row" style="margin-top: 20px;">
    <div class="col-md-12 table-responsive">
        <h1 style="margin-bottom: 20px;">Quản Lý Người Dùng</h1>

        <a href="edit.php"><button class="btn btn-success"> Thêm tài khoản </button></a>

        <table class="table table-bordered table-hover" style="margin-top: 20px;">
            <thead>
                <th>STT</th>
                <th>Họ & Tên</th> 
                <th>Email</th> 
                <th>SDT</th>
                <th>Địa Chỉ</th> 
                <th>Quyền</th>
                <th style="width : 50px"></th> 
                <th style="width : 50px"></th>
            </thead>
            <tbody>
<?php
         $index = 0;
            foreach($data as $item){
                echo '<tr>
                    <th>'.(++$index).'</th>
                    <td>'.$item['fullname'].'</td> 
                    <td>'.$item['email'].'</td> 
                    <td>'.$item['phone_number'].'</td> 
                    <td>'.$item['address'].'</td> 
                    <td>'.$item['role_name'].'</td>
                    <td style="width: 50px">
                        	<a href="edit.php?id='.$item['id'].'"><button class="btn btn-warning">Sửa</button></a>
                    </td> 
                   <td style="width: 50px">';
		if($user['id'] != $item['id'] && $item['role_id'] != 1) {
			echo '<button onclick="deleteUser('.$item['id'].')" class="btn btn-danger">Xoá</button>';
		}
		echo '
					</td>
                     </tr>';
                }
 ?>
            </tbody>
        </table>
    </div>
</div>

<script type="text/javascript">
	function deleteUser(id) {
		option = confirm('Bạn có chắc chắn muốn xoá tài khoản này không?')
		if(!option) return;

		$.post('form_delete.php', {
			'id': id,
			'action': 'delete'
		}, function(data) {
			location.reload()
		})
	}
</script>

<?php
     require_once('../layout/footer.php');
?>