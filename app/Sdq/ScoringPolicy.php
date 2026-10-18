<?php

namespace App\Sdq;

enum ScoringPolicy: string
{
    /**
     * The formula in the UNICEF scoring document:
     *   scale = average(answered items of the scale) * 5 + 0.5
     * where items answered "NA" are left out of the average.
     */
    case Documented = 'documented';

    /**
     * What the legacy application actually computed:
     *   scale = sum(answered items of the scale) + 0.5
     * i.e. the division by the number of answered items was never applied,
     * so an "NA" item simply contributed zero. Kept so historical scores
     * can be reproduced exactly when verifying the migration.
     */
    case Legacy = 'legacy';
}
