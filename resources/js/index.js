/*
 |--------------------------------------------------------------------------
 | Panzoom Image Alpine helper
 |--------------------------------------------------------------------------
 | Exposes a global `interactiveImage(imageUrl, imageId)` function that can
 | be used in Blade via x-data="interactiveImage(...)".
 */

 (function () {
    if (typeof window === 'undefined') return;

    window.interactiveImage = function (imageUrl, imageId, doubleClickZoomLevel = 3) {
        return {
            imageUrl: imageUrl,
            imageId: imageId,
            scale: 1,
            panX: 0,
            panY: 0,
            fittedScale: 1,
            fittedPanX: 0,
            fittedPanY: 0,
            originX: 0,
            originY: 0,
            isPanning: false,
            lastPanX: 0,
            lastPanY: 0,
            imageLoaded: false,
            containerBounds: null,
            imageBounds: null,
            minScale: 0.1,
            maxScale: 5,
            doubleClickZoomLevel: doubleClickZoomLevel,

            init() {
                this.$nextTick(() => {
                    this.updateBounds();
                });

                window.addEventListener('resize', () => {
                    this.updateBounds();
                });
            },

            onImageLoad() {
                this.imageLoaded = true;
                this.updateBounds();
                this.fitToContainer();
            },

            updateBounds() {
                if (this.$refs.container && this.$refs.image) {
                    this.containerBounds = this.$refs.container.getBoundingClientRect();
                    this.imageBounds = this.$refs.image.getBoundingClientRect();
                }
            },

            fitToContainer() {
                if (!this.imageLoaded || !this.$refs.container || !this.$refs.image) return;

                const container = this.$refs.container;
                const image = this.$refs.image;

                const containerWidth = container.offsetWidth;
                const containerHeight = container.offsetHeight;
                const imageWidth = image.naturalWidth;
                const imageHeight = image.naturalHeight;

                const scaleX = containerWidth / imageWidth;
                const scaleY = containerHeight / imageHeight;
                const newScale = Math.min(scaleX, scaleY, 1);

                // Center the image within the container using top-left origin math
                const centeredPanX = (containerWidth - imageWidth * newScale) / 2;
                const centeredPanY = (containerHeight - imageHeight * newScale) / 2;

                this.scale = newScale;
                this.panX = centeredPanX;
                this.panY = centeredPanY;

                // Store fitted state for precise toggling
                this.fittedScale = newScale;
                this.fittedPanX = centeredPanX;
                this.fittedPanY = centeredPanY;

                this.$nextTick(() => {
                    this.updateBounds();
                });
            },

            startPan(e) {
                if (e.target !== this.$refs.image) return;

                e.preventDefault();
                this.isPanning = true;
                this.lastPanX = e.clientX;
                this.lastPanY = e.clientY;

                this.$refs.image.style.cursor = 'grabbing';
            },

            pan(e) {
                if (!this.isPanning) return;

                e.preventDefault();

                const deltaX = e.clientX - this.lastPanX;
                const deltaY = e.clientY - this.lastPanY;

                this.panX += deltaX;
                this.panY += deltaY;
                this.constrainPan();

                this.lastPanX = e.clientX;
                this.lastPanY = e.clientY;
            },

            endPan() {
                if (this.isPanning) {
                    this.isPanning = false;
                    if (this.$refs.image) {
                        this.$refs.image.style.cursor = 'grab';
                    }
                }
            },

            doubleClickZoom(e) {
                if (e.target !== this.$refs.image) return;
                
                e.preventDefault();
                
                const rect = this.$refs.container.getBoundingClientRect();
                const clickX = e.clientX - rect.left;
                const clickY = e.clientY - rect.top;
                
                // Toggle: if we're approximately at fitted state, zoom in, else return to fitted state
                const near = (a, b, eps = 0.01) => Math.abs(a - b) <= eps;
                const isNearFitted = near(this.scale, this.fittedScale) && near(this.panX, this.fittedPanX, 1) && near(this.panY, this.fittedPanY, 1);

                if (isNearFitted) {
                    // Zoom to configurable level at the exact click position using top-left origin math
                    const newScale = Math.min(this.maxScale, this.doubleClickZoomLevel);

                    // Image coordinates of the click before scaling
                    const u = (clickX - this.panX) / this.scale;
                    const v = (clickY - this.panY) / this.scale;

                    // New pan to keep the clicked point stationary
                    const newPanX = clickX - (u * newScale);
                    const newPanY = clickY - (v * newScale);

                    this.scale = newScale;
                    this.panX = newPanX;
                    this.panY = newPanY;
                } else {
                    // Return to fitted state
                    this.scale = this.fittedScale;
                    this.panX = this.fittedPanX;
                    this.panY = this.fittedPanY;
                }

                this.constrainPan();
            },

            zoom(e) {
                e.preventDefault();

                const rect = this.$refs.container.getBoundingClientRect();
                const x = e.clientX - rect.left;
                const y = e.clientY - rect.top;

                const delta = e.deltaY > 0 ? -0.1 : 0.1;
                const newScale = Math.max(this.minScale, Math.min(this.maxScale, this.scale + delta));

                if (newScale !== this.scale) {
                    // Keep cursor point stationary (top-left origin math)
                    const u = (x - this.panX) / this.scale;
                    const v = (y - this.panY) / this.scale;

                    this.scale = newScale;
                    this.panX = x - (u * newScale);
                    this.panY = y - (v * newScale);

                    this.constrainPan();
                }
            },

            zoomIn() {
                const rect = this.$refs.container.getBoundingClientRect();
                const x = rect.width / 2;
                const y = rect.height / 2;
                const newScale = Math.min(this.maxScale, this.scale + 0.2);
                if (newScale !== this.scale) {
                    const u = (x - this.panX) / this.scale;
                    const v = (y - this.panY) / this.scale;
                    this.scale = newScale;
                    this.panX = x - (u * newScale);
                    this.panY = y - (v * newScale);
                    this.constrainPan();
                }
            },

            zoomOut() {
                const rect = this.$refs.container.getBoundingClientRect();
                const x = rect.width / 2;
                const y = rect.height / 2;
                const newScale = Math.max(this.minScale, this.scale - 0.2);
                if (newScale !== this.scale) {
                    const u = (x - this.panX) / this.scale;
                    const v = (y - this.panY) / this.scale;
                    this.scale = newScale;
                    this.panX = x - (u * newScale);
                    this.panY = y - (v * newScale);
                    this.constrainPan();
                }
            },

            reset() {
                this.fitToContainer();
            },

            constrainPan() {
                if (!this.$refs.container || !this.$refs.image) return;

                const container = this.$refs.container;
                const imageWidth = this.$refs.image.naturalWidth * this.scale;
                const imageHeight = this.$refs.image.naturalHeight * this.scale;
                const containerWidth = container.offsetWidth;
                const containerHeight = container.offsetHeight;

                // If the image is smaller than the container, keep it centered
                if (imageWidth <= containerWidth) {
                    this.panX = (containerWidth - imageWidth) / 2;
                } else {
                    const minPanX = containerWidth - imageWidth;
                    const maxPanX = 0;
                    this.panX = Math.max(minPanX, Math.min(maxPanX, this.panX));
                }

                if (imageHeight <= containerHeight) {
                    this.panY = (containerHeight - imageHeight) / 2;
                } else {
                    const minPanY = containerHeight - imageHeight;
                    const maxPanY = 0;
                    this.panY = Math.max(minPanY, Math.min(maxPanY, this.panY));
                }
            },

            startTouch(e) {
                if (e.target !== this.$refs.image) return;

                if (e.touches.length === 1) {
                    e.preventDefault();
                    this.startPan({
                        target: e.target,
                        clientX: e.touches[0].clientX,
                        clientY: e.touches[0].clientY,
                    });
                }
            },

            touch(e) {
                if (e.touches.length === 1 && this.isPanning) {
                    e.preventDefault();
                    this.pan({
                        clientX: e.touches[0].clientX,
                        clientY: e.touches[0].clientY,
                    });
                }
            },

            endTouch() {
                this.endPan();
            },
        };
    };
})();