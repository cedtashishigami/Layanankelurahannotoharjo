<!-- Real-Time Notification Bell Component -->
<div x-data="{
    open: false,
    unreadCount: 0,
    notifications: [],
    toast: null,
    toastTimer: null,
    csrfToken: '{{ csrf_token() }}',

    init() {
        this.fetchNotifications(true);
        // Polling setiap 20 detik secara background (efisien)
        setInterval(() => this.fetchNotifications(false), 20000);
    },

    fetchNotifications(isInitial = false) {
        fetch('{{ route('notifikasi.unread') }}', {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(res => res.json())
        .then(data => {
            const prevCount = this.unreadCount;
            this.unreadCount = data.unread_count;
            this.notifications = data.notifications;

            // Jika ada notifikasi baru masuk saat user sedang membuka halaman
            if (!isInitial && data.unread_count > prevCount && data.notifications.length > 0) {
                const newest = data.notifications[0];
                this.showToast(newest.judul, newest.pesan, newest.tautan);
            }
        })
        .catch(() => {});
    },

    showToast(title, message, url) {
        this.toast = { title, message, url };
        if (this.toastTimer) clearTimeout(this.toastTimer);
        this.toastTimer = setTimeout(() => {
            this.toast = null;
        }, 7000);
    },

    markAsRead(notif) {
        if (!notif.is_read) {
            fetch(`/notifikasi/${notif.id_notifikasi}/baca`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': this.csrfToken,
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(() => {
                notif.is_read = true;
                if (this.unreadCount > 0) this.unreadCount--;
            })
            .catch(() => {});
        }

        if (notif.tautan) {
            window.location.href = notif.tautan;
        }
    },

    markAllAsRead() {
        fetch('{{ route('notifikasi.readAll') }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': this.csrfToken,
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(() => {
            this.unreadCount = 0;
            this.notifications.forEach(n => n.is_read = true);
        })
        .catch(() => {});
    }
}" class="relative inline-block text-left" @click.outside="open = false">

    <!-- Bell Button -->
    <button type="button" 
            @click="open = !open" 
            class="relative w-9 h-9 sm:w-10 sm:h-10 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 flex items-center justify-center transition focus:outline-none"
            title="Pemberitahuan & Notifikasi">
        <i class="fa-regular fa-bell text-sm sm:text-base"></i>
        
        <!-- Red Pulsing Counter Badge -->
        <span x-show="unreadCount > 0" 
              x-transition:enter="transition ease-out duration-200"
              x-transition:enter-start="scale-0 opacity-0"
              x-transition:enter-end="scale-100 opacity-100"
              class="absolute -top-1 -right-1 px-1.5 py-0.5 min-w-[18px] h-[18px] bg-rose-600 text-white text-[10px] font-black rounded-full flex items-center justify-center shadow-sm animate-pulse"
              x-text="unreadCount > 9 ? '9+' : unreadCount"
              style="display: none;"></span>
    </button>

    <!-- Dropdown Popover Panel -->
    <div x-show="open" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 translate-y-2 scale-95"
         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0 scale-100"
         x-transition:leave-end="opacity-0 translate-y-2 scale-95"
         class="absolute right-0 mt-2 w-80 sm:w-96 bg-white rounded-3xl shadow-2xl border border-slate-200 overflow-hidden z-50 text-left"
         style="display: none;">
        
        <!-- Header -->
        <div class="px-5 py-3.5 bg-slate-900 text-white flex items-center justify-between">
            <div class="flex items-center space-x-2">
                <i class="fa-solid fa-bell text-emerald-400 text-xs"></i>
                <h4 class="font-bold text-xs tracking-wide uppercase">Pemberitahuan</h4>
                <span x-show="unreadCount > 0" class="px-2 py-0.5 bg-emerald-600 text-white text-[10px] font-bold rounded-full" x-text="unreadCount + ' Baru'" style="display: none;"></span>
            </div>
            <button type="button" 
                    @click="markAllAsRead()" 
                    x-show="unreadCount > 0"
                    class="text-[11px] text-emerald-300 hover:text-white font-semibold transition"
                    style="display: none;">
                Tandai Semua Dibaca
            </button>
        </div>

        <!-- Notification List -->
        <div class="max-h-80 overflow-y-auto divide-y divide-slate-100">
            <template x-if="notifications.length === 0">
                <div class="py-10 px-4 text-center text-xs text-slate-400 space-y-2">
                    <i class="fa-regular fa-bell-slash text-2xl text-slate-300 block"></i>
                    <p>Belum ada pemberitahuan.</p>
                </div>
            </template>

            <template x-for="notif in notifications" :key="notif.id_notifikasi">
                <div @click="markAsRead(notif)" 
                     class="p-4 hover:bg-slate-50 transition cursor-pointer flex items-start space-x-3 text-xs"
                     :class="notif.is_read ? 'bg-white opacity-75' : 'bg-emerald-50/40 font-medium'">
                    
                    <!-- Icon Status Indicator -->
                    <div class="w-8 h-8 rounded-xl flex items-center justify-center shrink-0 mt-0.5"
                         :class="notif.is_read ? 'bg-slate-100 text-slate-500' : 'bg-emerald-100 text-emerald-700'">
                        <i class="fa-solid" :class="notif.judul.toLowerCase().includes('selesai') || notif.judul.toLowerCase().includes('disetujui') ? 'fa-check' : (notif.judul.toLowerCase().includes('tolak') ? 'fa-xmark text-rose-600' : 'fa-info')"></i>
                    </div>

                    <div class="flex-grow space-y-1 min-w-0">
                        <div class="flex items-center justify-between gap-1">
                            <strong class="text-slate-900 block truncate" x-text="notif.judul"></strong>
                            <span class="text-[10px] text-slate-400 shrink-0" x-text="notif.waktu"></span>
                        </div>
                        <p class="text-slate-600 text-[11px] leading-relaxed line-clamp-2" x-text="notif.pesan"></p>
                    </div>

                    <!-- Unread Dot -->
                    <div x-show="!notif.is_read" class="w-2 h-2 rounded-full bg-emerald-500 shrink-0 mt-2" style="display: none;"></div>
                </div>
            </template>
        </div>
    </div>

    <!-- Floating Real-Time Toast Alert (Top Right) -->
    <div x-show="toast" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-[-20px] scale-95"
         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0 scale-100"
         x-transition:leave-end="opacity-0 translate-y-[-20px] scale-95"
         class="fixed top-5 right-5 z-50 max-w-sm w-full bg-slate-900 text-white rounded-2xl shadow-2xl p-4 border border-emerald-500/50 flex items-start space-x-3"
         style="display: none;">
        
        <div class="w-9 h-9 rounded-xl bg-emerald-500 text-slate-950 flex items-center justify-center shrink-0 font-bold text-sm">
            <i class="fa-solid fa-bell animate-bounce"></i>
        </div>

        <div class="flex-grow text-xs space-y-1 min-w-0">
            <strong class="block text-emerald-400 font-bold truncate" x-text="toast ? toast.title : ''"></strong>
            <p class="text-slate-300 line-clamp-2 leading-relaxed" x-text="toast ? toast.message : ''"></p>
            <div class="pt-1 flex items-center space-x-3">
                <template x-if="toast && toast.url">
                    <a :href="toast.url" class="text-[11px] font-bold text-emerald-400 hover:text-emerald-300 underline">Lihat Detail &rarr;</a>
                </template>
                <button type="button" @click="toast = null" class="text-[11px] text-slate-400 hover:text-white">Tutup</button>
            </div>
        </div>

        <button type="button" @click="toast = null" class="text-slate-400 hover:text-white p-1">
            <i class="fa-solid fa-xmark text-xs"></i>
        </button>
    </div>
</div>

