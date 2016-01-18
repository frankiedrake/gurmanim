<?php
if (!empty($_REQUEST['send'])) {
    ?>
    <div>
        Your message was sent!
    </div>
    <?php
}
?>
<form method="POST">
    <div>
        <label for="from">From</label> <input type="text" name="from" id="from">
    </div>
    <div>
        <label for="from_email">From Email</label> <input type="text" name="from_email" id="from_email">
    </div>
    <div>
        <label for="to_email">To Email</label> <input type="text" name="to_email" id="to_email">
    </div>
    <div>
        <label for="subject">Subject</label> <input type="text" name="subject" id="subject">
    </div>
    <div>
        <label for="message">Message</label> <textarea name="message" id="message" cols="30" rows="10"></textarea>
    </div>
    <div>
        <button type="submit" value="send">Send</button>
    </div>
</form>