<?php

declare(strict_types=1);

namespace App\Support;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception as PHPMailerException;
use Throwable;

/**
 * Thin SMTP mail wrapper around PHPMailer.
 *
 * Sending is a no-op (returns false) when SMTP isn't configured, so local dev
 * and form handling never break — submissions are stored in the DB regardless.
 */
final class Mailer
{
    /** @var array<string,mixed>|null */
    private static ?array $config = null;

    private static function config(): array
    {
        if (self::$config === null) {
            self::$config = require dirname(__DIR__, 2) . '/config/mail.php';
        }
        return self::$config;
    }

    /** Whether SMTP credentials are present. */
    public static function isConfigured(): bool
    {
        return self::config()['host'] !== '';
    }

    /**
     * Send a plain-text email. Returns true on success, false if disabled or
     * on failure (failures are swallowed so they never break the user flow).
     */
    public static function send(string $toEmail, string $subject, string $body, ?string $replyTo = null): bool
    {
        if (!self::isConfigured()) {
            return false;
        }

        $cfg  = self::config();
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host       = $cfg['host'];
            $mail->Port       = $cfg['port'];
            $mail->SMTPAuth   = true;
            $mail->Username   = $cfg['username'];
            $mail->Password   = $cfg['password'];
            $mail->SMTPSecure = $cfg['encryption'];

            $mail->setFrom($cfg['from'], $cfg['from_name']);
            $mail->addAddress($toEmail);
            if ($replyTo !== null && filter_var($replyTo, FILTER_VALIDATE_EMAIL)) {
                $mail->addReplyTo($replyTo);
            }

            $mail->Subject = $subject;
            $mail->Body    = $body;

            return $mail->send();
        } catch (PHPMailerException | Throwable) {
            // Don't surface mail errors to the user; the DB record is the source of truth.
            return false;
        }
    }

    /** Where contact-form notifications should be delivered. */
    public static function adminAddress(): string
    {
        return self::config()['to'];
    }

    private function __construct()
    {
    }
}
