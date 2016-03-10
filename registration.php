
    <form class="form form-horizontal" action="action.php?method=registration" method="post">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                    aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Registration</h4>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="form-group">
                    <label for="email" class="col-sm-4 control-label">Email</label>
                    <div class="col-sm-6">
                        <input type="email" id="email" name="email" class="form-control" value="">
                    </div>
                </div>
                <div class="form-group">
                    <label for="password" class="col-sm-4 control-label">Password</label>
                    <div class="col-sm-6">
                        <input type="password" id="password" name="password" class="form-control"
                               value="">
                    </div>
                </div>
                <hr>
                <div class="form-group">
                    <label for="name" class="col-sm-4 control-label">Name</label>
                    <div class="col-sm-6">
                        <input type="text" id="name" name="name" class="form-control" value="">
                    </div>
                </div>
                <div class="form-group">
                    <label for="last_name" class="col-sm-4 control-label">Last Name</label>
                    <div class="col-sm-6">
                        <input type="text" id="last_name" name="last_name" class="form-control"
                               value="">
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-success">Registration</button>
        </div>
    </form>




