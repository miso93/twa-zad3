
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Login history</h4>
    </div>
    <div class="modal-body">
        <h5>My history</h5>
        <table class="table table-responsive table-striped">
            <thead>
            <tr>
                <th>Type</th>
                <th>Timestamp</th>
            </tr>
            </thead>
            <tbody>
                <?php foreach($histories_login as $login): ?>
                   <tr>
                       <td>
                           <?php echo $login->login_type; ?>
                       </td>
                       <td>
                           <?php echo $login->login_at; ?>
                       </td>
                   </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <h5>Application history</h5>
        <table class="table table-responsive table-striped">
            <thead>
            <tr>
                <th>Type</th>
                <th>Login count</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($all_history as $login): ?>
                <tr>
                    <td>
                        <?php echo $login->login_type; ?>
                    </td>
                    <td>
                        <?php echo $login->count; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    </div>




