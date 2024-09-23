<div class="wrap smtp2go">
    <table class="smtp2go-logs-table">
        <thead>
            <tr>
                <th>Site</th>
                <th>To</th>
                <th>From</th>
                <th>Subject</th>
                <th>Request</th>
                <th>Response</th>
                <th>Created At</th>
                <th>Updated At</th>
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
                    <td><?php echo htmlentities($log->request); ?></td>
                    <td>
                        <?php
                            echo 'Request ID: ' . $res->request_id . '<br>';
                            if (isset($res->data->succeeded)) {
                                echo 'Success: ' . $res->data->succeeded . '<br>';
                            }
                            if (isset($res->data->failed)) {
                                echo 'Failed: ' . $res->data->failed . '<br>';
                            }
                            if (isset($res->data->email_id)) {
                                echo 'Email ID: ' . $res->data->email_id . '<br>';
                            }
                        ?>
                    </td>
                    <td><?php echo $log->created_at; ?></td>
                    <td><?php echo $log->updated_at; ?></td>
                </tr>
            <?php endforeach; ?>
    </table>
</div>