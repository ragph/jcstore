export default class Gate {

    constructor(user) {
        this.user = user;
        console.log(user);
    }
    Userprofile() {
        return this.user;
    }
    isRenter() {
        return this.user.role == 'renter';
    }
    isAdmin() {
        return this.user.role == 'admin';
    }
    isCashier() {
        return this.user.role == 'cashier';
    }
    isStaff() {
        return this.user.role == 'staff';
    }
    isManager() {
            return this.user.role == 'manager';
        }
        // branch menu
    branch_View_() {
        return this.user.roles.branch == '1';
    }
    branch_Add_() {
        return this.user.roles.branch == '2';
    }
    branch_Edit_() {
        return this.user.roles.branch == '3';
    }
    branch_Delete_() {
        return this.user.roles.branch == '4';
    }
    branch_Add_Edit() {
        return this.user.roles.branch == '5';
    }
    branch_Add_Delete() {
        return this.user.roles.branch == '6';
    }
    branch_Edit_Delete() {
        return this.user.roles.branch == '7';
    }
    branch_Add_Edit_Delete() {
        return this.user.roles.branch == '8';
    }
    branch_null() {
        return this.user.roles.branch == null;
    }
    branch_is_NOTnull() {
            return this.user.roles.branch != null;
        }
        //  Renters menu

    renter_View_() {
        return this.user.roles.renters_profile == '1';
    }
    renter_Add_() {
        return this.user.roles.renters_profile == '2';
    }
    renter_Edit_() {
        return this.user.roles.renters_profile == '3';
    }
    renter_Delete_() {
        return this.user.roles.renters_profile == '4';
    }
    renter_Add_Edit() {
        return this.user.roles.renters_profile == '5';
    }
    renter_Add_Delete() {
        return this.user.roles.renters_profile == '6';
    }
    renter_Edit_Delete() {
        return this.user.roles.renters_profile == '7';
    }
    renter_Add_Edit_Delete() {
        return this.user.roles.renters_profile == '8';
    }
    renter_null() {
        return this.user.roles.renters_profile == null;
    }
    renter_is_NOTnull() {
            return this.user.roles.renters_profile != null;
        }
        // cube
    cube_View_() {
        return this.user.roles.cube_management == '1';
    }
    cube_Add_() {
        return this.user.roles.cube_management == '2';
    }
    cube_Edit_() {
        return this.user.roles.cube_management == '3';
    }
    cube_Delete_() {
        return this.user.roles.cube_management == '4';
    }
    cube_Add_Edit() {
        return this.user.roles.cube_management == '5';
    }
    cube_Add_Delete() {
        return this.user.roles.cube_management == '6';
    }
    cube_Edit_Delete() {
        return this.user.roles.cube_management == '7';
    }
    cube_Add_Edit_Delete() {
        return this.user.roles.cube_management == '8';
    }
    cube_null() {
        return this.user.roles.cube_management == null;
    }
    cube_is_NOTnull() {
        return this.user.roles.cube_management != null;
    }

    // product
    product_View_() {
        return this.user.roles.product_management == '1';
    }
    product_Add_() {
        return this.user.roles.product_management == '2';
    }
    product_Edit_() {
        return this.user.roles.product_management == '3';
    }
    product_Delete_() {
        return this.user.roles.product_management == '4';
    }
    product_Add_Edit() {
        return this.user.roles.product_management == '5';
    }
    product_Add_Delete() {
        return this.user.roles.product_management == '6';
    }
    product_Edit_Delete() {
        return this.user.roles.product_management == '7';
    }
    product_Add_Edit_Delete() {
        return this.user.roles.product_management == '8';
    }
    product_null() {
        return this.user.roles.product_management == null;
    }
    product_is_NOTnull() {
            return this.user.roles.product_management != null;
        }
        // inventory
    inventory_View_() {
        return this.user.roles.inventory == '1';
    }
    inventory_Add_() {
        return this.user.roles.inventory == '2';
    }
    inventory_Edit_() {
        return this.user.roles.inventory == '3';
    }
    inventory_Delete_() {
        return this.user.roles.inventory == '4';
    }
    inventory_Add_Edit() {
        return this.user.roles.inventory == '5';
    }
    inventory_Add_Delete() {
        return this.user.roles.inventory == '6';
    }
    inventory_Edit_Delete() {
        return this.user.roles.inventory == '7';
    }
    inventory_Add_Edit_Delete() {
        return this.user.roles.inventory == '8';
    }
    inventory_null() {
        return this.user.roles.inventory == null;
    }
    inventory_is_NOTnull() {
        return this.user.roles.inventory != null;
    }

    // POS
    pos_View_() {
        return this.user.roles.pos == '1';
    }
    pos_Add_() {
        return this.user.roles.pos == '2';
    }
    pos_Edit_() {
        return this.user.roles.pos == '3';
    }
    pos_Delete_() {
        return this.user.roles.pos == '4';
    }
    pos_Add_Edit() {
        return this.user.roles.pos == '5';
    }
    pos_Add_Delete() {
        return this.user.roles.pos == '6';
    }
    pos_Edit_Delete() {
        return this.user.roles.pos == '7';
    }
    pos_Add_Edit_Delete() {
        return this.user.roles.pos == '8';
    }
    pos_null() {
        return this.user.roles.pos == null;
    }
    pos_is_NOTnull() {
            return this.user.roles.pos != null;
        }
        // user
    user_View_() {
        return this.user.roles.users == '1';
    }
    user_Add_() {
        return this.user.roles.users == '2';
    }
    user_Edit_() {
        return this.user.roles.users == '3';
    }
    user_Delete_() {
        return this.user.roles.users == '4';
    }
    user_Add_Edit() {
        return this.user.roles.users == '5';
    }
    user_Add_Delete() {
        return this.user.roles.users == '6';
    }
    user_Edit_Delete() {
        return this.user.roles.users == '7';
    }
    user_Add_Edit_Delete() {
        return this.user.roles.users == '8';
    }
    user_null() {
        return this.user.roles.users == null;
    }
    user_is_NOTnull() {
            return this.user.roles.users != null;
        }
        // rent management
    rent_View_() {
        return this.user.roles.rent_management == '1';
    }
    rent_Add_() {
        return this.user.roles.rent_management == '2';
    }
    rent_Edit_() {
        return this.user.roles.rent_management == '3';
    }
    rent_Delete_() {
        return this.user.roles.rent_management == '4';
    }
    rent_Add_Edit() {
        return this.user.roles.rent_management == '5';
    }
    rent_Add_Delete() {
        return this.user.roles.rent_management == '6';
    }
    rent_Edit_Delete() {
        return this.user.roles.rent_management == '7';
    }
    rent_Add_Edit_Delete() {
        return this.user.roles.rent_management == '8';
    }
    rent_null() {
        return this.user.roles.rent_management == null;
    }
    rent_is_NOTnull() {
        return this.user.roles.rent_management != null;
    }

    // report
    report_View_() {
        return this.user.roles.report == '1';
    }
    report_null() {
        return this.user.roles.rent_management == null;
    }
    report_is_NOTnull() {
            return this.user.roles.rent_management != null;
        }
        // settings
    setting_View_() {
        return this.user.roles.settings == '1';
    }
    setting_Add_() {
        return this.user.roles.settings == '2';
    }
    setting_Edit_() {
        return this.user.roles.settings == '3';
    }
    setting_Delete_() {
        return this.user.roles.settings == '4';
    }
    setting_Add_Edit() {
        return this.user.roles.settings == '5';
    }
    setting_Add_Delete() {
        return this.user.roles.settings == '6';
    }
    setting_Edit_Delete() {
        return this.user.roles.settings == '7';
    }
    setting_Add_Edit_Delete() {
        return this.user.roles.settings == '8';
    }
    setting_null() {
        return this.user.roles.settings == null;
    }
    setting_is_NOTnull() {
            return this.user.roles.settings != null;
        }
        // settings
    sale_coll_View_() {
        return this.user.roles.sale_collections == '1';
    }
    sale_coll_Add_() {
        return this.user.roles.sale_collections == '2';
    }
    sale_coll_Edit_() {
        return this.user.roles.sale_collections == '3';
    }
    sale_coll_Delete_() {
        return this.user.roles.sale_collections == '4';
    }
    sale_coll_Add_Edit() {
        return this.user.roles.sale_collections == '5';
    }
    sale_coll_Add_Delete() {
        return this.user.roles.sale_collections == '6';
    }
    sale_coll_Edit_Delete() {
        return this.user.roles.sale_collections == '7';
    }
    sale_coll_Add_Edit_Delete() {
        return this.user.roles.sale_collections == '8';
    }
    sale_coll_null() {
        return this.user.roles.sale_collections == null;
    }
    sale_coll_is_NOTnull() {
        return this.user.roles.sale_collections != null;
    }



}