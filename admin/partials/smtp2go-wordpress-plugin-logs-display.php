<div class="wrap smtp2go">
    <table class="smtp2go-logs-table">
        <thead>
            <tr>
                <th>Site</th>
                <th>To</th>
                <th>From</th>
                <th>Subject</th>
                <th width="20%">Request</th>
                <th>Response</th>
                <th>Created</th>
                <th>Updated</th>
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
                        <?php if (!empty($log->request) && strpos($log->request, '{') === 0) :
                            $req = json_decode($log->request, true);
                        ?>
                            <pre style="height:200px;overflow:scroll;max-width: 400px;">
                                <?php echo htmlentities(print_r($req, 1)); ?>
                            </pre>
                       
                        <?php endif; ?>
                    </td>
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