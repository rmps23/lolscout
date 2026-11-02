<?php

namespace App\Services;

use RuntimeException;

/** A rule of the roster was broken; the message is safe to show to players. */
class TeamRosterException extends RuntimeException {}
