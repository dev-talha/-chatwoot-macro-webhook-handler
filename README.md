# Unichat.com.bd Macro Webhook Handler

This repository contains a PHP script to handle **Unichat Macro Webhooks** securely.  
It allows Unichat agents to trigger actions (like adding a label) and send a webhook POST request to your server, which can then process it (e.g., log, update database, send notifications).

---

## Features

- Handles `macro_executed` events from Unichat
- Validates:
  - JSON payload
  - Required fields (`event`, `macro`, `conversation`)
  - Event type (`macro_executed`)
  - Labels array
  - Secret token for authorization
- Optional: IP whitelisting for additional security
- Easy to extend for custom workflows (email, API calls, database updates)

---

## Requirements

- PHP 7.x or higher
- Web server with HTTPS support (recommended)
- Unichat account with admin access to create Macros

---

## Installation

1. Clone the repository:

```bash
git clone https://github.com/YOUR_USERNAME/Unichat-webhook-handler.git
cd Unichat-webhook-handler
