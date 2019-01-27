## Laravel Helper
| Feature |  Purpose |
|:-------:|:--------:|
|  `Base\Enum` Class | It has basic `Enum` functionality |
|  `Base\Filter` Class | It is parent filter |
|  `Base\Approvable` Trait | It add methods and scopes to model like `approved()`, `isApproved()` |
|  `Base\BaseActions` Trait | It handles `created_by`, `updated_by`, `deleted_by` |
|  `$table->baseActions()` | It adds `created_by`, `updated_by`, `deleted_by`, `timestamps()`, and `softDeletes()` to table |
|  `$table->approval()` | It adds `approved_by` and `approved_at` columns to table |
|  `Route::approve('user', 'UserController')` | It adds `PUT user/{user}/approved` route |


## TODO: Add all features
