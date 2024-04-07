<script>
  import MenuLink from '@/Layouts/Components/MenuLink.svelte'
</script>

<div class="menu">
  <MenuLink text="О проекте" href="/" />
  <MenuLink text="Данные пользователей" href="/user-infos" />
  <MenuLink text="Данные отделов" href="/departments" />
  <div class="flex-1"></div>
  <MenuLink text="Импорт" href="/import" />
</div>

<style lang="scss">
  .menu {
    @apply flex w-full bg-gray-50;
  }
</style>
