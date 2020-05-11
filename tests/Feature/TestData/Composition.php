<?php

class Arm {}
class Leg {}
class Body {
	protected Arm $leftArm;
	protected Arm $rightArm;
	protected Leg $leftLeg;
	protected Leg $rightLeg;
	protected int $limbs;
	protected $unknown;
}