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
                this.scale = Math.min(scaleX, scaleY, 1);

                this.panX = 0;
                this.panY = 0;

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
                
                // Toggle between fit-to-container and configurable zoom at click position
                if (this.scale <= 1) {
                    // Zoom to configurable level at the exact click position
                    const newScale = Math.min(this.maxScale, this.doubleClickZoomLevel);
                    
                    // Calculate the position on the image where user clicked
                    // First, get the current image position relative to container
                    const imageX = clickX - this.panX;
                    const imageY = clickY - this.panY;
                    
                    // Calculate the ratio of click position relative to current image size
                    const imageWidth = this.$refs.image.naturalWidth * this.scale;
                    const imageHeight = this.$refs.image.naturalHeight * this.scale;
                    const clickRatioX = imageX / imageWidth;
                    const clickRatioY = imageY / imageHeight;
                    
                    // Calculate new image dimensions
                    const newImageWidth = this.$refs.image.naturalWidth * newScale;
                    const newImageHeight = this.$refs.image.naturalHeight * newScale;
                    
                    // Calculate new pan to keep the clicked point in the same position
                    const newPanX = clickX - (newImageWidth * clickRatioX);
                    const newPanY = clickY - (newImageHeight * clickRatioY);
                    
                    this.panX = newPanX;
                    this.panY = newPanY;
                    this.scale = newScale;
                } else {
                    // Reset to fit container
                    this.fitToContainer();
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
                    const scaleDiff = newScale - this.scale;
                    const centerX = rect.width / 2;
                    const centerY = rect.height / 2;
                    this.panX -= (x - centerX) * scaleDiff;
                    this.panY -= (y - centerY) * scaleDiff;

                    this.scale = newScale;
                    this.constrainPan();
                }
            },

            zoomIn() {
                const newScale = Math.min(this.maxScale, this.scale + 0.2);
                this.scale = newScale;
                this.constrainPan();
            },

            zoomOut() {
                const newScale = Math.max(this.minScale, this.scale - 0.2);
                this.scale = newScale;
                this.constrainPan();
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

                const maxPanX = Math.max(0, (imageWidth - containerWidth) / 2);
                const maxPanY = Math.max(0, (imageHeight - containerHeight) / 2);

                this.panX = Math.max(-maxPanX, Math.min(maxPanX, this.panX));
                this.panY = Math.max(-maxPanY, Math.min(maxPanY, this.panY));
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