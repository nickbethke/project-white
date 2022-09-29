# Module hooks

## Default Hooks (every module)

| Hook                   | Description                |  args  |
|------------------------|----------------------------|:------:|
| on_module_activation   | When module is activated   |   -    |
| on_module_deactivation | When module is deactivated |   -    |

## Overview Hook (OverviewModule)

| Hook                        | Description                                         |              args              |
|-----------------------------|-----------------------------------------------------|:------------------------------:|
| before_overview_head_closed | Before the \<head\> is closed on the dashboard page | &StyleHandler:, &ScriptHandler |
| before_overview_body_closed | Before the \<body\> is closed on the dashboard page | &StyleHandler:, &ScriptHandler |
| on_overview_print           | When it is time to print the new overview section   |               -                |