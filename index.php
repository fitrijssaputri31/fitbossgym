<?php
require 'koneksi.php';

// Ambil data jadwal kelas
$sql_schedule = "SELECT * FROM class_schedule ORDER BY FIELD(day_of_week, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu')";
$result_schedule = mysqli_query($koneksi, $sql_schedule);

// Ambil data testimoni
$sql_testimonials = "SELECT * FROM testimonials LIMIT 2"; // Batasi hanya 2 testimoni
$result_testimonials = mysqli_query($koneksi, $sql_testimonials);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FitBoss Gym - Shape Your Dream Body</title>
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&family=Oswald:wght@700&display=swap" rel="stylesheet">
</head>
<body>

    <header class="navbar">
        <div class="container">
            <a href="#" class="logo">Fit<span>Boss</span></a>
            <nav>
                <ul>
                    <li><a href="#paket">Packages</a></li>
                    <li><a href="#jadwal">Schedule</a></li>
                    <li><a href="#testimoni">Testimonials</a></li>
                </ul> 
            </nav>
            <div class="auth-buttons">
                <a href="login.html" class="btn btn-secondary">LOGIN</a>
                <a href="register.html" class="btn btn-primary">SIGN UP</a>
            </div>
        </div>
    </header>

    <main>
        <section class="hero">
            <div class="hero-overlay"></div>
            <div class="container hero-content">
                <h1>Get Your Dream Body, <br>Starting Today</h1>
                <p>Join thousands of members who have changed their lives with us.</p>
                <a href="#paket" class="btn btn-primary btn-large">View Membership Packages</a>
            </div>
        </section>

        <section id="paket" class="section">
            <div class="container">
                <h2 class="section-title">Choose a package according to your needs</h2>
                <div class="paket-container">
                    <div class="paket-card">
                        <h3>Membership Gym</h3>
                        <p class="harga">Rp 250.000 <span>/ month</span></p>
                        <ul>
                            <li>✅ Full Access to Gym Area</li>
                            <li>✅ Locker & Shower Room</li>
                            <li>✅ Initial Equipment Guidance</li>
                        </ul>
                        <a href="register.html?plan=Gym+Membership" class="btn btn-primary">Choose Package</a>
                    </div>
                    <div class="paket-card featured">
                        <span class="badge">Most Popular</span>
                        <h3>Gym + Class</h3>
                        <p class="harga">Rp 300.000 <span>/ month</span></p>
                        <ul>
                            <li>✅ All Gym Package Benefits</li>
                            <li>✅ Access to All Classes</li>
                            <li>✅ Online Class Booking System</li>
                        </ul>
                        <a href="register.html?plan=Gym+%2B+Class" class="btn btn-primary">Choose Package</a>
                    </div>
                    <div class="paket-card">
                        <h3>Private Coach</h3>
                        <p class="harga">Starts from Rp 1.000.000</p>
                        <ul>
                            <li>✅ Personalized Training Program</li>
                            <li>✅ Nutrition Consultation</li>
                            <li>✅ Body Analysis</li>
                        </ul>
                        <a href="#" id="view-coaches-btn" class="btn btn-primary">View Coaches</a>
                    </div>
                </div>
            </div>
        </section>

        <section id="jadwal" class="section section-dark">
            <div class="container">
                <h2 class="section-title">Weekly Class Schedule</h2>
                <div class="jadwal-grid">
    <?php while ($schedule = mysqli_fetch_assoc($result_schedule)) { ?>
        <div class="jadwal-card" style="background-image: url('images/<?php echo htmlspecialchars($schedule['class_image_url']); ?>');">
            <div class="info">
                <h3><?php echo strtoupper(htmlspecialchars($schedule['day_of_week'])); ?></h3>
                <p><?php echo htmlspecialchars($schedule['class_name']); ?> - <?php echo htmlspecialchars($schedule['coach_name']); ?></p>
            </div>
        </div>
    <?php } ?>
</div>
            </div>
        </section>

        </section>

<section id="fasilitas" class="section">
    <div class="container">
        <h2 class="section-title">Fasilitas Kami</h2>
        <div class="fasilitas-grid">
            <div class="fasilitas-card">
                <div class="icon">🏋️‍♂️</div>
                <h3>Area Gym</h3>
            </div>
            <div class="fasilitas-card">
                <div class="icon">🧘‍♀️</div>
                <h3>Area Kelas</h3>
            </div>
            <div class="fasilitas-card">
                <div class="icon">🏃‍♀️</div>
                <h3>Area Cardio</h3>
            </div>
            <div class="fasilitas-card">
                <div class="icon">💪</div>
                <h3>Area Fit Camp</h3>
            </div>
            <div class="fasilitas-card">
                <div class="icon">🚗</div>
                <h3>Area Parkir</h3>
            </div>
            <div class="fasilitas-card">
                 <div class="icon">🚹</div>
                 <h3>Toilet Pria</h3>
            </div>
            <div class="fasilitas-card">
                <div class="icon">🚺</div>
                 <h3>Toilet Wanita</h3>
            </div>
        </div>
    </div>
</section>

        <section id="testimoni" class="section">
            <div class="testimoni-container">
    <?php while ($testimonial = mysqli_fetch_assoc($result_testimonials)) { ?>
        <div class="testimoni-card">
            <img src="images/<?php echo htmlspecialchars($testimonial['member_photo_url']); ?>" alt="Foto Member" class="profile-pic">
            <p class="quote">"<?php echo htmlspecialchars($testimonial['testimonial_text']); ?>"</p>
            <p class="author">- <?php echo htmlspecialchars($testimonial['member_name']); ?>, <?php echo htmlspecialchars($testimonial['member_type']); ?></p>
        </div>
    <?php } ?>
</div>
        </section>
    </main>

    <footer class="footer">
        <div class="container">
            <a href="#" class="logo">Fit<span>Boss</span></a>
            <p class="alamat">Taman Sakura Cigasong, Majalengka</p>
            <div class="social-media">
                <a href="#">IG</a> 
            </div>
            <p class="copyright">&copy; 2025 FitBoss Gym. Dibuat untuk Tugas Besar UNMA.</p>
        </div>
    </footer>

    <div id="coach-modal" class="modal">
        <div class="modal-overlay"></div>
        <div class="modal-content">
            <button class="close-modal">&times;</button>
            <h2 class="section-title">Choose Your Personal Coach</h2>
            <div class="coach-container-modal">
                <div class="coach-card">
                    <img src="images/coach-joe.jpg" alt="Foto Coach Joe" class="coach-pic" loading="lazy">
                    <h3>Coach Joe</h3>
                    <p class="harga">Rp 1.700.000 <span>/ 10 Sesi</span></p>
                    <a href="#" class="btn btn-secondary">Choose Coach Joe</a>
                </div>
                <div class="coach-card">
                    <img src="images/coach-eka.jpg" alt="Foto Coach Eka" class="coach-pic" loading="lazy">
                    <h3>Coach Eka</h3>
                    <p class="harga">Rp 1.400.000 <span>/ 10 Sesi</span></p>
                    <a href="#" class="btn btn-secondary">Choose Coach Eka</a>
                </div>
                <div class="coach-card">
                    <img src="images/coach-anton.jpg" alt="Foto Coach Anton" class="coach-pic" loading="lazy">
                    <h3>Coach Anton</h3>
                    <p class="harga">Rp 1.000.000 <span>/ 10 Sesi</span></p>
                    <a href="#" class="btn btn-secondary">Choose Coach Anton</a>
                </div>
            </div>
        </div>
    </div>

    <script>
      // Script untuk membuka dan menutup modal
      const modal = document.getElementById('coach-modal');
      const openModalBtn = document.getElementById('view-coaches-btn');
      const closeModalBtn = document.querySelector('.close-modal');
      const overlay = document.querySelector('.modal-overlay');

      function openModal(e) {
        if (e) e.preventDefault();  
        modal.style.display = 'block';
        document.body.style.overflow = 'hidden'; 
      }
      function closeModal() {
        modal.style.display = 'none';
        document.body.style.overflow = '';
      }

      openModalBtn.addEventListener('click', openModal);
      closeModalBtn.addEventListener('click', closeModal);
      overlay.addEventListener('click', closeModal);
      document.addEventListener('keydown', e => {
        if (e.key === 'Escape' && modal.style.display === 'block') closeModal();
      });
    </script>
    <script>
      // Script untuk tombol "Choose Coach" di dalam modal
      document.querySelector('.coach-container-modal')
        .addEventListener('click', (e) => {
          const a = e.target.closest('a.btn');
          if (!a) return;
          e.preventDefault();
          const name = a.textContent.trim().replace('Choose ',''); // "Coach Joe"
          const url = new URL('register.html', location.href);
          url.searchParams.set('plan', 'private');
          url.searchParams.set('coach', name);
          location.href = url.toString();
        });
    </script>



</body>
</html>