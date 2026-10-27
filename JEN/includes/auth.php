<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

function requireAuth(): void
{
    if (empty($_SESSION['user'])) {
        header('Location: login.php');
        exit;
    }
}

function requireGuest(): void
{
    if (!empty($_SESSION['user'])) {
        header('Location: dashboard.php');
        exit;
    }
}

function currentUserName(): string
{
    return $_SESSION['user']['name'] ?? '';
}
