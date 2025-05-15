<div class="wrap smtp2go">
    <?php if (!empty($logs)) : ?>
    <table class="smtp2go-logs-table">
        <thead>
            <tr>
                <th>Site</th>
                <th>To</th>
                <th>From</th>
                <th>Subject</th>
                <th>Response</th>
                <th>Created</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($logs as $log) :
                $to = json_decode($log->to);
                $res = json_decode($log->response);
            ?>
                <tr>
                    <td><?php echo $log->site_id; ?></td>
                    <td><?php
                        if (is_array($to)) {
                            foreach ($to as $recipient) {
                                echo htmlentities($recipient) . '<br>';
                            }
                        } else {
                            echo htmlentities($log->to);
                        }
                        ?></td>
                    <td><?php echo htmlentities($log->from); ?></td>
                    <td><?php echo htmlentities($log->subject); ?></td>
                   
                    <td>
                        <?php
                        echo 'Request ID: ' . $res->request_id . '<br>';
                        if (isset($res->data->succeeded)) {
                            echo 'Success: ' . $res->data->succeeded . '<br>';
                        }
                        if (isset($res->data->failed)) {
                            echo 'Failed: ' . $res->data->failed . '<br>';
                        }
                        if (isset($res->data->error)) {
                            echo 'Error: ' . $res->data->error . '<br>';
                        }
                        if (isset($res->data->email_id)) {
                            echo 'Email ID: ' . $res->data->email_id . '<br>';
                        }
                        if (isset($res->data->failures[0])) {
                            echo  $res->data->failures[0] . '<br>';
                        }
                        ?>
                    </td>
                    <td><?php echo $log->created_at; ?></td>
                </tr>
            <?php endforeach; ?>
    </table>
    <p>Showing latest <?php echo count($logs); ?> logs out of a total of <?php echo $totalLogs ?></p>
    <!-- download as csv button -->
     <a href="<?php echo admin_url('admin.php?action=downloadSmtp2goLogs'); ?>" class="button button-primary">Download CSV</a>

     <!-- truncate logs button -->
        <a href="<?php echo admin_url('admin.php?action=truncateSmtp2goLogs'); ?>" class="button button-warning" onclick="return confirm('Are you sure you want to remove all log entries for SMT2GO?')">Truncate Logs</a>
    <?php else : ?>
        <p>No logs found</p>
    <?php endif; ?>
</div>