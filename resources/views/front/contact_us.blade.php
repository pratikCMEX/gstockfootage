<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Document</title>
</head>

<body>
    <form id="contactForm" action="{{ route('contact.add') }}" method="POST">
        @csrf

        <input type="text" name="name" id="name" placeholder="Name *">
        <input type="email" name="email" id="email" placeholder="Email *">
        <input type="text" name="subject" id="subject" placeholder="Subject *">
        <textarea name="message" id="message" placeholder="Message *"></textarea>

        <button type="submit">Send Message</button>
    </form>

</body>

</html>
