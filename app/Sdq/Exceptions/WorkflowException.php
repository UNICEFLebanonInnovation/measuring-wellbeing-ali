<?php

namespace App\Sdq\Exceptions;

use RuntimeException;

/** A business-rule violation in the application workflow (safe to show to the user). */
class WorkflowException extends RuntimeException {}
