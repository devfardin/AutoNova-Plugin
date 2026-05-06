<?php
namespace Fardin\Autonova\Shortcodes;
if (!defined('ABSPATH')) {
    exit;
}
class TeamMember
{
    use \Fardin\Autonova\App\Traits\Singletion;
    public function init()
    {
        add_shortcode('autonova-teammember', [$this, 'autonova_teammember']);
    }
    public function autonova_teammember()
    {
        ob_start();
        wp_enqueue_style('autonova-team-member');
        $team_members = get_field('team_members', 'option'); ?>
        <div class="team-member_wrapper">
            <?php if ($team_members): ?>
                <div class="team-member__grid">
                    <?php foreach ($team_members as $member): ?>
                        <div class="team-member__card">
                            <?php if (!empty($member['photo'])): ?>
                                <div class="team-member__thumb">
                                    <img src="<?php echo esc_url($member['photo']); ?>" alt="<?php echo esc_attr($member['name']); ?>">
                                    <div class="team-member__gradient"></div>
                                    <div class="team-member__info">
                                        <span class="divider"></span>
                                        <?php if (!empty($member['name'])): ?>
                                            <h3 class="team-member__name"><?php echo esc_html($member['name']);
                                            ?></h3>
                                        <?php endif;
                                        if (!empty($member['role'])): ?>
                                            <span class="team-member__role"><?php echo esc_html($member['role']); ?></span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <?php if (!empty($member['bio'])): ?>
                                <div class="team-member__content">
                                    <p><?php echo esc_html($member['bio']);
                                    ?></p>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="team-member__message">
                    <p><?php esc_html_e('No team members found.', 'autonova'); ?>
                </div>
            <?php endif; ?>
        </div>
        <?php
        return ob_get_clean();
    }
}
