@if ($paginator->hasPages())
  <nav class="pagination" role="navigation" aria-label="Pagination">
    @if ($paginator->onFirstPage())
      <span class="btn btn-ghost btn-sm" aria-disabled="true" style="opacity:.4">‹ Previous</span>
    @else
      <a class="btn btn-ghost btn-sm" href="{{ $paginator->previousPageUrl() }}" rel="prev">‹ Previous</a>
    @endif
    <span>Page {{ $paginator->currentPage() }} of {{ $paginator->lastPage() }}</span>
    @if ($paginator->hasMorePages())
      <a class="btn btn-ghost btn-sm" href="{{ $paginator->nextPageUrl() }}" rel="next">Next ›</a>
    @else
      <span class="btn btn-ghost btn-sm" aria-disabled="true" style="opacity:.4">Next ›</span>
    @endif
  </nav>
@endif
