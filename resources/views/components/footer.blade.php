<!-- Footer -->
<footer class="footer">
    <div class="footer-content">
        <!-- Column 1: About -->
        <div class="footer-column">
            <h3 class="footer-title">
                <i class="fas fa-utensils text-orange-500 mr-2"></i>
                ResepinAja
            </h3>
            <p class="footer-text">
                Platform berbagi resep masakan terbaik di Indonesia. Temukan dan bagikan resep favoritmu dengan mudah!
            </p>
            <div class="footer-social">
                <a href="https://facebook.com/resepinaja" target="_blank" class="footer-social-link" title="Facebook">
                    <i class="fab fa-facebook-f"></i>
                </a>
                <a href="https://instagram.com/resepinaja" target="_blank" class="footer-social-link" title="Instagram">
                    <i class="fab fa-instagram"></i>
                </a>
                <a href="https://twitter.com/resepinaja" target="_blank" class="footer-social-link" title="Twitter">
                    <i class="fab fa-twitter"></i>
                </a>
                <a href="https://youtube.com/resepinaja" target="_blank" class="footer-social-link" title="YouTube">
                    <i class="fab fa-youtube"></i>
                </a>
                <a href="https://tiktok.com/@resepinaja" target="_blank" class="footer-social-link" title="TikTok">
                    <i class="fab fa-tiktok"></i>
                </a>
            </div>
        </div>

        <!-- Column 2: Quick Links -->
        <div class="footer-column">
            <h3 class="footer-title">Menu Cepat</h3>
            <ul class="footer-links">
                <li>
                    <a href="{{ route('home') }}" class="footer-link">
                        <i class="fas fa-chevron-right text-xs mr-2"></i>Beranda
                    </a>
                </li>
                
                @guest
                    <li>
                        <a href="{{ route('login') }}" class="footer-link">
                            <i class="fas fa-chevron-right text-xs mr-2"></i>Login
                        </a>
                    </li>
                @else
                    <li>
                        <a href="{{ route('recipes.create') }}" class="footer-link">
                            <i class="fas fa-chevron-right text-xs mr-2"></i>Upload Resep
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('chat.index') }}" class="footer-link">
                            <i class="fas fa-chevron-right text-xs mr-2"></i>Chat ResepinBot
                        </a>
                    </li>
                    @if(Auth::user()->isAdmin())
                        <li>
                            <a href="{{ route('admin.users') }}" class="footer-link">
                                <i class="fas fa-chevron-right text-xs mr-2"></i>Kelola Akun User
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.recipes') }}" class="footer-link">
                                <i class="fas fa-chevron-right text-xs mr-2"></i>Kelola Resep User
                            </a>
                        </li>
                    @else
                        <li>
                            <a href="{{ route('profile') }}" class="footer-link">
                                <i class="fas fa-chevron-right text-xs mr-2"></i>Profil Saya
                            </a>
                        </li>
                    @endif
                @endguest
            </ul>
        </div>

        <!-- Column 3: Contact Info -->
        <div class="footer-column">
            <h3 class="footer-title">Hubungi Kami</h3>
            <ul class="footer-contact">
                <li class="footer-contact-item">
                    <i class="fas fa-envelope text-orange-500 mr-3"></i>
                    <div>
                        <p class="text-xs text-gray-400">Email</p>
                        <a href="mailto:info@resepinaja.com" class="footer-link">info@resepinaja.com</a>
                    </div>
                </li>
                <li class="footer-contact-item">
                    <i class="fas fa-phone text-orange-500 mr-3"></i>
                    <div>
                        <p class="text-xs text-gray-400">Telepon</p>
                        <a href="tel:+6281234567890" class="footer-link">+62 812-3456-7890</a>
                    </div>
                </li>
                <li class="footer-contact-item">
                    <i class="fas fa-map-marker-alt text-orange-500 mr-3"></i>
                    <div>
                        <p class="text-xs text-gray-400">Alamat</p>
                        <p class="footer-text">Jember, Jawa Timur<br>Indonesia</p>
                    </div>
                </li>
            </ul>
        </div>
    </div>

    <!-- Footer Bottom -->
    <div class="footer-bottom">
        <div class="footer-bottom-content">
            <p class="footer-copyright">
                © {{ date('Y') }} ResepinAja. Berbagi Resep. Berbagi Cinta.
            </p>
            <div class="footer-bottom-links">
                <a href="#" class="footer-bottom-link">Kebijakan Privasi</a>
                <span class="text-gray-600">•</span>
                <a href="#" class="footer-bottom-link">Syarat & Ketentuan</a>
                <span class="text-gray-600">•</span>
                <a href="#" class="footer-bottom-link">Bantuan</a>
            </div>
        </div>
    </div>
</footer>