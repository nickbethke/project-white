<?php

require_once ABSPATH . "vendor/tracy/tracy/src/Tracy/Bar/IBarPanel.php";

class UserPanel implements \Tracy\IBarPanel
{

    function getTab(): string
    {
        return '<span title="tooltip">
	                <span class="tracy-label">User</span>
                </span>';
    }

    function getPanel(): string
    {
        $user = Session::getInstance()->get_user();
        return '<h1>Current User</h1>
                <div class="tracy-inner">
                    <div class="tracy-inner-container">
	                   <table class="tracy-sortable">
                            <tbody>
                            <tr><td>ID</td><td>' . $user->getId() . '</td></tr>                        
                            <tr><td>Name</td><td>' . $user->getFirstname() . ' ' . $user->getSurname() . '</td></tr>
                            <tr><td>Nickname</td><td>' . $user->getNickname() . '</td></tr>
                            <tr><td>Email</td><td>' . $user->getEmail() . '</td></tr>
                            </tbody>
                       </table>
                    </div>
                </div>';
    }
}