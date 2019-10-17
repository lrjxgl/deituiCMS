var vueTouch=function () {
	return {
		x: 0,
		y: 0,
		dx: 10,
		dy: 10,
		inTouch: false,
		inMove:false,
		moveX: 0,
		moveY: 0,
		touchstart: function(e) {
			//event.stopPropagation();
			this.inTouch = true;
			this.x = e.touches[0].clientX;
			this.y = e.touches[0].clientY;
		},
		touchmove: function(e) {
			if (!this.inTouch && !this.inMove) {
				return;
			}

			var dx = e.touches[0].clientX - this.x;
			var dy = this.y - e.touches[0].clientY;
			this.moveX = dx;
			this.moveY = dy;
			if (Math.abs(dx) > Math.abs(dy)) {

				if (dx > this.dx) {
					this.inTouch = false;
					return "swipeRight";
				}
				if (dx < -this.dx) {
					this.inTouch = false;
					return "swipeLeft";
				}
			} else {
				if (dy > this.dy) {
					this.inTouch = false;
					return "swipeUp";
				}
				if (dy < -this.dy) {
					this.inTouch = false;
					return "swipeDown";
				}
			}
		},
		touchend: function(e) {

			if (!this.inTouch && !this.inMove) {
				return;
			}
			this.inTouch=false;
			this.inMove=false;
			//console.log(e.changedTouches[0]);
			var dx = e.changedTouches[0].clientX - this.x;
			var dy = this.y - e.changedTouches[0].clientY;
			this.moveX = dx;
			this.moveY = dy;
			if (Math.abs(dx) > Math.abs(dy)) {

				if (dx > this.dx) {
					this.inTouch = false;
					return "swipeRight";
				}
				if (dx < -this.dx) {
					this.inTouch = false;
					return "swipeLeft";
				}
			} else {
				if (dy > this.dy) {
					this.inTouch = false;
					return "swipeUp";
				}
				if (dy < -this.dy) {
					this.inTouch = false;
					return "swipeDown";
				}
			}
		}
	}
};
//module.exports=vueTouch;