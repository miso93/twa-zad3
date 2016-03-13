<form class="form form-horizontal" action="action.php?method=processSetPassword" method="post">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Set password</h4>
    </div>
    <div class="modal-body">
        <div class="row">
            <div class="form-group">
                <label for="password" class="col-sm-4 control-label">Password</label>
                <div class="col-sm-6">
                    <input type="password" id="password" name="password" class="form-control" value="">
                </div>
            </div>
            <div class="form-group">
                <label for="password_confirm" class="col-sm-4 control-label">Password confirm</label>
                <div class="col-sm-6">
                    <input type="password" id="password_confirm" name="password_confirm" class="form-control" value="">
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-success">Set password</button>
    </div>
</form>




