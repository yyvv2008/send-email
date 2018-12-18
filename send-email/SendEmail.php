<?php
/**
 * Created by PhpStorm.
 * User: wyang
 * Date: 2018/12/17
 * Time: 14:42
 */

namespace Job;


use PHPMailer\PHPMailer\PHPMailer;

class SendEmail
{
    private $addresses;
    private $subject;
    private $body;

    public function setAddresses($addresses)
    {
        return $this->addresses = $addresses;
    }

    public function setSubject($subject)
    {
        return $this->subject = $subject;
    }

    public function setBody($body)
    {
        return $this->body = $body;
    }

    public function putJob()
    {
        if (!($this->addresses && $this->subject && $this->body)) {
            return false;
        }

        $job = serialize($this);
        return (new Common())->put($job);
    }

    public function exec()
    {
        $mail = new PHPMailer(true);
        try {
            //Server settings
            $mail->SMTPDebug = 0;                                 // Enable verbose debug output
            $mail->CharSet = 'utf-8';
            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = 'smtp.qq.com';  // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = '591012658@qq.com';                 // SMTP username
            $mail->Password = 'krpdkfhdsewabbbc';                           // SMTP password
            $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 587;                                    // TCP port to connect to

            //Recipients
            $mail->setFrom('591012658@qq.com');

            foreach ($this->addresses as $address) {
                $mail->addAddress($address);
            }

            //Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = $this->subject;
            $mail->Body = $this->body;

            $mail->send();
        } catch (\Exception $e) {
            // log
        }
    }
}
