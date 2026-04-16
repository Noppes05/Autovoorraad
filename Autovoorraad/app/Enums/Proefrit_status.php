<?php

namespace App;

enum Proefrit_status: string
{
    // ['afgerond','gepland','bezig', 'geannuleerd']
    case AFGEROND = 'afgerond';
    case GEPLAND = 'gepland';
    case BEZIG = 'bezig';
    case GEANNULEERD = 'geannuleerd';
}
