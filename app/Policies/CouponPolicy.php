<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\Coupon;
use Illuminate\Auth\Access\HandlesAuthorization;

class CouponPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the admin can view any models.
     */
    public function viewAny(Admin $admin): bool
    {
        return true; // admins can view coupons in their team context
    }

    /**
     * Determine whether the admin can view the model.
     */
    public function view(Admin $admin, Coupon $coupon): bool
    {
        // admins can view global coupons or coupons for their team
        return $coupon->created_by === $admin->id;
    }

    /**
     * Determine whether the admin can create models.
     */
    public function create(Admin $admin): bool
    {
        // All admins can create coupons since we're using a separate admin guard
        // and not relying on role/permission seeder for admin panel
        return true;
    }

    /**
     * Determine whether the admin can update the model.
     */
    public function update(Admin $admin, Coupon $coupon): bool
    {
        // Only team owners can update coupons for their team
        return $coupon->created_by === $admin->id;
    }

    /**
     * Determine whether the admin can delete the model.
     */
    public function delete(Admin $admin, Coupon $coupon): bool
    {
        // Only team owners can delete coupons for their team
        return $coupon->created_by === $admin->id;
    }

    /**
     * Determine whether the admin can restore the model.
     */
    public function restore(Admin $admin, Coupon $coupon): bool
    {
        return $this->delete($admin, $coupon);
    }

    /**
     * Determine whether the admin can permanently delete the model.
     */
    public function forceDelete(Admin $admin, Coupon $coupon): bool
    {
        return $this->delete($admin, $coupon);
    }
}
