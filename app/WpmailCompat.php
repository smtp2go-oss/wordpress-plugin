<?php
namespace SMTP2GO\App;

/**
 * provides wp_mail compatible functionality using sections of code from
 * the original function
 */
class WpmailCompat
{
    public function processHeaders($headers)
    {
        // Headers
        $cc = $bcc = $reply_to = array();

        $parsed_header_data = array();

        $from_email = $from_name = null;

        if (empty($headers)) {
            $headers = array();
        } else {
            if (!is_array($headers)) {
                // Explode the headers out, so this function can take both
                // string headers and an array of headers.
                $tempheaders = explode("\n", str_replace("\r\n", "\n", $headers));
            } else {
                $tempheaders = $headers;
            }
            $headers = array();

            // If it's actually got contents
            if (!empty($tempheaders)) {
                // Iterate through the raw headers
                foreach ((array) $tempheaders as $header) {
                    if (strpos($header, ':') === false) {
                        if (false !== stripos($header, 'boundary=')) {
                            $parts    = preg_split('/boundary=/i', trim($header));
                            $boundary = trim(str_replace(array("'", '"'), '', $parts[1]));
                        }
                        continue;
                    }
                    // Explode them out
                    list($name, $content) = explode(':', trim($header), 2);

                    // Cleanup crew
                    $name    = trim($name);
                    $content = trim($content);

                    switch (strtolower($name)) {
                        // Mainly for legacy -- process a From: header if it's there
                        case 'from':
                            $bracket_pos = strpos($content, '<');
                            if ($bracket_pos !== false) {
                                // Text before the bracketed email is the "From" name.
                                if ($bracket_pos > 0) {
                                    $from_name = substr($content, 0, $bracket_pos - 1);
                                    $from_name = str_replace('"', '', $from_name);
                                    $from_name = trim($from_name);
                                }

                                $from_email = substr($content, $bracket_pos + 1);
                                $from_email = str_replace('>', '', $from_email);
                                $from_email = trim($from_email);

                                // Avoid setting an empty $from_email.
                            } elseif ('' !== trim($content)) {
                                $from_email = trim($content);
                            }
                            break;
                        case 'content-type':
                            if (strpos($content, ';') !== false) {
                                list($type, $charset_content) = explode(';', $content);
                                $content_type                 = trim($type);
                                if (false !== stripos($charset_content, 'charset=')) {
                                    $charset = trim(str_replace(array('charset=', '"'), '', $charset_content));
                                } elseif (false !== stripos($charset_content, 'boundary=')) {
                                    $boundary = trim(str_replace(array('BOUNDARY=', 'boundary=', '"'), '', $charset_content));
                                    $charset  = '';
                                }

                                // Avoid setting an empty $content_type.
                            } elseif ('' !== trim($content)) {
                                $content_type = trim($content);
                            }
                            break;
                        case 'cc':
                            $cc = array_merge((array) $cc, explode(',', $content));
                            break;
                        case 'bcc':
                            $bcc = array_merge((array) $bcc, explode(',', $content));
                            break;
                        case 'reply-to':
                            $reply_to = array_merge((array) $reply_to, explode(',', $content));
                            break;
                        default:
                            // Add it to our grand headers array
                            $headers[trim($name)] = trim($content);
                            break;
                    }
                }
            }
        }

        $parsed_header_data['from_name']    = $from_name;
        $parsed_header_data['from_email']   = $from_email;
        $parsed_header_data['cc']           = $cc;
        $parsed_header_data['bcc']          = $bcc;
        $parsed_header_data['reply-to']     = $reply_to;
        $parsed_header_data['headers']      = $headers;
        $parsed_header_data['content-type'] = !empty($content_type) ? $content_type : null;
        $parsed_header_data['charset']      = !empty($charset) ? $charset : null;
        $parsed_header_data['boundary']     = !empty($boundary) ? $boundary : null;

        return $parsed_header_data;
    }
    /**
     * Process wp_mail attachments which are either a string filepath
     * or an array of file paths
     *
     * @param string|array $wp_attachments
     * @return void
     */
    public function processAttachments($wp_attachments)
    {

        if (!is_array($wp_attachments)) {
            $wp_attachments = explode("\n", str_replace("\r\n", "\n", $wp_attachments));
        }

        return $wp_attachments;
    }
}
