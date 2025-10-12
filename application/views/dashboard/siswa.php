<!-- ========================= -->
<!-- DASHBOARD SISWA CONTENT -->
<!-- ========================= -->

<main class="main">

  <!-- Courses Hero Section -->
  <section id="courses-hero" class="courses-hero section light-background">
    <div class="hero-content">
      <div class="container">
        <div class="row align-items-center">

          <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">
            <div class="hero-text">
              <h1>Transform Your Future with Expert-Led Online Courses</h1>
              <p>Discover thousands of high-quality courses designed by industry professionals. Learn at your own pace, gain in-demand skills, and advance your career from anywhere in the world.</p>

              <div class="hero-stats">
                <div class="stat-item">
                  <span class="number purecounter" data-purecounter-start="0" data-purecounter-end="50000" data-purecounter-duration="2"></span>
                  <span class="label">Students Enrolled</span>
                </div>
                <div class="stat-item">
                  <span class="number purecounter" data-purecounter-start="0" data-purecounter-end="1200" data-purecounter-duration="2"></span>
                  <span class="label">Expert Courses</span>
                </div>
                <div class="stat-item">
                  <span class="number purecounter" data-purecounter-start="0" data-purecounter-end="98" data-purecounter-duration="2"></span>
                  <span class="label">Success Rate %</span>
                </div>
              </div>

              <div class="hero-buttons">
                <a href="<?= site_url('materi'); ?>" class="btn btn-primary">Browse Courses</a>
                <a href="#about" class="btn btn-outline">Learn More</a>
              </div>

              <div class="hero-features">
                <div class="feature">
                  <i class="bi bi-shield-check"></i>
                  <span>Certified Programs</span>
                </div>
                <div class="feature">
                  <i class="bi bi-clock"></i>
                  <span>Lifetime Access</span>
                </div>
                <div class="feature">
                  <i class="bi bi-people"></i>
                  <span>Expert Instructors</span>
                </div>
              </div>
            </div>
          </div>

          <div class="col-lg-6" data-aos="fade-up" data-aos-delay="200">
            <div class="hero-image">
              <div class="main-image">
                <img src="<?= base_url('assets/img/education/courses-13.webp'); ?>" alt="Online Learning" class="img-fluid">
              </div>

              <div class="floating-cards">
                <div class="course-card" data-aos="fade-up" data-aos-delay="300">
                  <div class="card-icon"><i class="bi bi-code-slash"></i></div>
                  <div class="card-content">
                    <h6>Web Development</h6><span>2,450 Students</span>
                  </div>
                </div>

                <div class="course-card" data-aos="fade-up" data-aos-delay="400">
                  <div class="card-icon"><i class="bi bi-palette"></i></div>
                  <div class="card-content">
                    <h6>UI/UX Design</h6><span>1,890 Students</span>
                  </div>
                </div>

                <div class="course-card" data-aos="fade-up" data-aos-delay="500">
                  <div class="card-icon"><i class="bi bi-graph-up"></i></div>
                  <div class="card-content">
                    <h6>Digital Marketing</h6><span>3,200 Students</span>
                  </div>
                </div>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>

    <div class="hero-background">
      <div class="bg-shapes">
        <div class="shape shape-1"></div>
        <div class="shape shape-2"></div>
        <div class="shape shape-3"></div>
      </div>
    </div>
  </section>

  <!-- Featured Courses Section -->
  <section id="featured-courses" class="featured-courses section">
    <div class="container section-title" data-aos="fade-up">
      <h2>Featured Courses</h2>
      <p>Necessitatibus eius consequatur ex aliquid fuga eum quidem sint consectetur velit</p>
    </div>

    <div class="container" data-aos="fade-up" data-aos-delay="100">
      <div class="row gy-4">
        <!-- Contoh kursus -->
        <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
          <div class="course-card">
            <div class="course-image">
              <img src="<?= base_url('assets/img/education/students-9.webp'); ?>" alt="Course" class="img-fluid">
              <div class="badge featured">Featured</div>
              <div class="price-badge">$149</div>
            </div>
            <div class="course-content">
              <div class="course-meta">
                <span class="level">Beginner</span><span class="duration">8 Weeks</span>
              </div>
              <h3><a href="#">Digital Marketing Fundamentals</a></h3>
              <p>Lorem ipsum dolor sit amet consectetur adipiscing elit sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
              <div class="instructor">
                <img src="<?= base_url('assets/img/person/person-f-3.webp'); ?>" alt="Instructor" class="instructor-img">
                <div class="instructor-info"><h6>Sarah Johnson</h6><span>Marketing Expert</span></div>
              </div>
              <div class="course-stats">
                <div class="rating">
                  <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-half"></i>
                  <span>(4.5)</span>
                </div>
                <div class="students">
                  <i class="bi bi-people-fill"></i><span>342 students</span>
                </div>
              </div>
             <a href="<?= site_url('enroll'); ?>" class="btn-course">Enroll Now</a>
            </div>
          </div>
        </div>
        <!-- Kamu bisa menyalin block di atas untuk kursus lain -->
      </div>

      <div class="more-courses text-center" data-aos="fade-up" data-aos-delay="500">
        <a href="<?= site_url('materi'); ?>" class="btn-more">View All Courses</a>
      </div>
    </div>
  </section>

  <!-- Course Categories Section -->
  <section id="course-categories" class="course-categories section">
    <div class="container section-title" data-aos="fade-up">
      <h2>Course Categories</h2>
      <p>Necessitatibus eius consequatur ex aliquid fuga eum quidem sint consectetur velit</p>
    </div>

    <div class="container" data-aos="fade-up" data-aos-delay="100">
      <div class="row g-4">
        <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6" data-aos="zoom-in" data-aos-delay="100">
          <a href="<?= site_url('materi'); ?>" class="category-card category-tech">
            <div class="category-icon"><i class="bi bi-laptop"></i></div>
            <h5>Computer Science</h5><span class="course-count">24 Courses</span>
          </a>
        </div>
        <!-- Lanjutkan kategori lain sesuai template -->
      </div>
    </div>
  </section>

  <!-- CTA Section -->
  <section id="cta" class="cta section light-background">
    <div class="container" data-aos="fade-up" data-aos-delay="100">
      <div class="row align-items-center">
        <div class="col-lg-6" data-aos="fade-right" data-aos-delay="200">
          <div class="cta-content">
            <h2>Transform Your Future with Expert-Led Online Courses</h2>
            <p>Join thousands of successful learners who have advanced their careers through our platform.</p>
            <div class="cta-actions" data-aos="fade-up" data-aos-delay="500">
              <a href="<?= site_url('materi'); ?>" class="btn btn-primary">Browse Courses</a>
              <a href="#" class="btn btn-outline">Enroll Now</a>
            </div>
          </div>
        </div>
        <div class="col-lg-6" data-aos="fade-left" data-aos-delay="300">
          <div class="cta-image">
            <img src="<?= base_url('assets/img/education/courses-4.webp'); ?>" alt="Online Learning Platform" class="img-fluid">
          </div>
        </div>
      </div>
    </div>
  </section>

</main>
