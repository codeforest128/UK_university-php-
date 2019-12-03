<div class="modal" id="update_pass">
    <div class="modal-dialog">
        <div class="modal-header">
            <h4 class="modal-title">Change Password</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
            <form method="POST" action="change_password.php">
                <label>Current Password</label>
                <input type="password" name="password"/>
                <label>New Password</label>
                <input type="password" name="new_password"/>
                <label>Confirm New Password</label>
                <input type="password" name="confirm_new_password">
                <input type="submit"/>
            </form>
        </div>
    </div>
</div>