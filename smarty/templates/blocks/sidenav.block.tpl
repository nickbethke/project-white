{block name="sidenav"}
    <aside class="w-72 h-screen fixed" aria-label="Sidebar">
        <div class="overflow-y-auto py-4 px-3 bg-gray-800 h-[100%]">
            <a href="{$home_url}" class="flex items-center pl-2.5 mb-5">
                <img src="/content/img/logo.png" class="mr-3 h-6 sm:h-7" alt="Project White Logo"/>
                <span class="self-center text-xl font-semibold whitespace-nowrap dark:text-white uppercase">Project White</span>
            </a>
            <ul class="space-y-2">
                <li>
                    <a href="{$home_url}"
                       class="flex items-center p-2 text-base font-normal text-gray-900 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 {if $selected_page eq 'home'}sidebar-active-item{/if}">
                        <svg aria-hidden="true"
                             class="w-6 h-6 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"
                             fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z"></path>
                            <path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z"></path>
                        </svg>
                        <span class="ml-3">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="{$home_url}/inbox.php"
                       class="flex items-center p-2 text-base font-normal text-gray-900 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 {if $selected_page eq 'inbox'}sidebar-active-item{/if}">
                        <svg aria-hidden="true"
                             class="flex-shrink-0 w-6 h-6 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"
                             fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path d="M8.707 7.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l2-2a1 1 0 00-1.414-1.414L11 7.586V3a1 1 0 10-2 0v4.586l-.293-.293z"></path>
                            <path d="M3 5a2 2 0 012-2h1a1 1 0 010 2H5v7h2l1 2h4l1-2h2V5h-1a1 1 0 110-2h1a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2V5z"></path>
                        </svg>
                        <span class="flex-1 ml-3 whitespace-nowrap">Inbox</span>
                        {if $notifications > 0}
                            <span class="inline-flex justify-center items-center p-3 ml-3 w-3 h-3 text-sm font-medium rounded-full bg-green-900 text-white-200">{$notifications}</span>
                        {/if}
                    </a>
                    {if $selected_page eq 'inbox' ||$selected_page eq 'inbox-new'||$selected_page eq 'inbox-archived'||$selected_page eq 'inbox-create'}
                        <ul id="dropdown-sidenav-inbox"
                            class="py-2 space-y-2 text-sm">
                            <li>
                                <a href="{$home_url}/inbox.php?action=create"
                                   class="flex items-center p-2 pl-11 w-full font-normal text-gray-900 transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700  {if $selected_page eq 'inbox-create'}sidebar-active-item{/if}">
                                    Create</a>
                            </li>
                            <li>
                                <a href="{$home_url}/inbox.php?status=new"
                                   class="flex items-center p-2 pl-11 w-full font-normal text-gray-900 transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700  {if $selected_page eq 'inbox-new'}sidebar-active-item{/if}">
                                    New</a>
                            </li>
                            <li>
                                <a href="{$home_url}/inbox.php?status=archived"
                                   class="flex items-center p-2 pl-11 w-full font-normal text-gray-900 transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700  {if $selected_page eq 'inbox-archived'}sidebar-active-item{/if}">Archived</a>
                            </li>
                        </ul>
                    {/if}
                </li>
                <li>
                    <a href="{$home_url}/projects.php"
                       class="flex items-center p-2 text-base font-normal text-gray-900 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 {if $selected_page eq 'projects'}sidebar-active-item{/if}">
                        <svg aria-hidden="true"
                             class="flex-shrink-0 w-6 h-6 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"
                             fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                        </svg>
                        <span class="flex-1 ml-3 whitespace-nowrap">Projects</span>
                    </a>
                </li>
            </ul>
            <ul class="pt-4 mt-4 space-y-2 border-t border-gray-200 dark:border-gray-700">
                <li>
                    <button type="button"
                            class="flex items-center p-2 w-full text-base font-normal text-gray-900 transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                            aria-controls="dropdown-sidenav-user" data-collapse-toggle="dropdown-sidenav-user">
                        <svg aria-hidden="true"
                             class="flex-shrink-0 w-6 h-6 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white"
                             fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                  d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                  clip-rule="evenodd"></path>
                        </svg>
                        <span class="flex-1 ml-3 text-left whitespace-nowrap" sidebar-toggle-item>User</span>
                        <svg sidebar-toggle-item class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"
                             xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                  d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                  clip-rule="evenodd"></path>
                        </svg>
                    </button>
                    <ul id="dropdown-sidenav-user"
                        class="{if !($selected_page|in_array:['user','user-billing']) }hidden{/if} py-2 space-y-2 text-sm">
                        <li>
                            <a href="{$home_url}/user.php"
                               class="flex items-center p-2 pl-11 w-full font-normal text-gray-900 transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700  {if $selected_page eq 'user'}sidebar-active-item{/if}">Account
                                Info</a>
                        </li>
                        <li>
                            <a href="{$home_url}/user-billing.php"
                               class="flex items-center p-2 pl-11 w-full font-normal text-gray-900 transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 {if $selected_page eq 'user-billing'}sidebar-active-item{/if}">Bills</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="{$home_url}/config.php"
                       class="flex items-center p-2 text-base font-normal text-gray-900 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 {if $selected_page eq 'config'}sidebar-active-item{/if}">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                             class="w-6 h-6 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white">
                            <path fill-rule="evenodd"
                                  d="M11.078 2.25c-.917 0-1.699.663-1.85 1.567L9.05 4.889c-.02.12-.115.26-.297.348a7.493 7.493 0 00-.986.57c-.166.115-.334.126-.45.083L6.3 5.508a1.875 1.875 0 00-2.282.819l-.922 1.597a1.875 1.875 0 00.432 2.385l.84.692c.095.078.17.229.154.43a7.598 7.598 0 000 1.139c.015.2-.059.352-.153.43l-.841.692a1.875 1.875 0 00-.432 2.385l.922 1.597a1.875 1.875 0 002.282.818l1.019-.382c.115-.043.283-.031.45.082.312.214.641.405.985.57.182.088.277.228.297.35l.178 1.071c.151.904.933 1.567 1.85 1.567h1.844c.916 0 1.699-.663 1.85-1.567l.178-1.072c.02-.12.114-.26.297-.349.344-.165.673-.356.985-.57.167-.114.335-.125.45-.082l1.02.382a1.875 1.875 0 002.28-.819l.923-1.597a1.875 1.875 0 00-.432-2.385l-.84-.692c-.095-.078-.17-.229-.154-.43a7.614 7.614 0 000-1.139c-.016-.2.059-.352.153-.43l.84-.692c.708-.582.891-1.59.433-2.385l-.922-1.597a1.875 1.875 0 00-2.282-.818l-1.02.382c-.114.043-.282.031-.449-.083a7.49 7.49 0 00-.985-.57c-.183-.087-.277-.227-.297-.348l-.179-1.072a1.875 1.875 0 00-1.85-1.567h-1.843zM12 15.75a3.75 3.75 0 100-7.5 3.75 3.75 0 000 7.5z"
                                  clip-rule="evenodd"/>
                        </svg>
                        <span class="ml-3">Configuration</span>
                    </a>
                </li>
                <li>
                    <a href="{$home_url}/#logout"
                       class="flex items-center p-2 text-base font-normal text-gray-900 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 pw-action"
                       action="logout-prompt">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white">
                            <path fill-rule="evenodd"
                                  d="M7.5 3.75A1.5 1.5 0 006 5.25v13.5a1.5 1.5 0 001.5 1.5h6a1.5 1.5 0 001.5-1.5V15a.75.75 0 011.5 0v3.75a3 3 0 01-3 3h-6a3 3 0 01-3-3V5.25a3 3 0 013-3h6a3 3 0 013 3V9A.75.75 0 0115 9V5.25a1.5 1.5 0 00-1.5-1.5h-6zm5.03 4.72a.75.75 0 010 1.06l-1.72 1.72h10.94a.75.75 0 010 1.5H10.81l1.72 1.72a.75.75 0 11-1.06 1.06l-3-3a.75.75 0 010-1.06l3-3a.75.75 0 011.06 0z"
                                  clip-rule="evenodd"/>
                        </svg>
                        <span class="ml-3">Logout</span>
                    </a>
                </li>
            </ul>
            {if $user->getActivationKey() != ""}
                <div id="dropdown-cta" class="p-4 mt-6 bg-green-900" role="alert">
                    <div class="flex items-center mb-3">
                        <span class="bg-orange-100 text-orange-800 text-sm font-semibold mr-2 px-2.5 py-0.5 rounded dark:bg-orange-200 dark:text-orange-900">Activation</span>
                    </div>
                    <p class="mb-3 text-sm text-white">
                        Activate your account by verifying your email.
                    </p>
                    <p class="mb-3 text-sm text-white">
                        We've emailed you with a verification link. Please check your emails.
                    </p>
                </div>
            {/if}
        </div>
    </aside>
{/block}