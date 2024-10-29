<?php

if (!file_exists('madeline.php')) {
    copy('https://phar.madelineproto.xyz/madeline.php', 'madeline.php');
}

include 'madeline.php';

$MadelineProto = new \danog\MadelineProto\API('session.madeline');
$MadelineProto->start();

//getting the contacts
$contacts = $MadelineProto->contacts->getContacts();


// Check if there are any contacts
if (!empty($contacts['users'])) {
    $userIdsToDelete = [];

    foreach ($contacts['users'] as $user) {
        // Exclude your own account by checking the 'self' attribute or matching your user ID
        if (empty($user['self'])) {
            $userIdsToDelete[] = $user['id'];
        }
    }

    // Proceed only if there are contacts to delete (excluding yourself)
    if (!empty($userIdsToDelete)) {
        $result = $MadelineProto->contacts->deleteContacts(['id' => $userIdsToDelete]);
        $countContact = count($userIdsToDelete) > 1 ? " contacts have been deleted.</p>" : " contact has been deleted.</p>";
        $contactsFound = "<p style='color:green'>" . count($userIdsToDelete) . $countContact;
        echo $contactsFound;

        
    } else {
        $noContactFound = "<p style='color:red'>No contacts found to delete.</p>";
        echo $noContactFound;
    }
}
